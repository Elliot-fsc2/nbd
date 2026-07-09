# Blood Donation Management System — Plan

## Overview

A Laravel + Inertia React application for managing blood donation drives. Students/employees fill a universal personal-info form online, the system auto-assigns them to a hospital, generates a partially-filled PDF via dompdf, emails it to them, and on event day staff manages the queue.

---

## 1. User Types & Roles

| Role  | Access                              |
|-------|-------------------------------------|
| Student | Fill form on homepage (no auth)   |
| Admin | Full CRUD: hospitals, events, etc.  |
| Staff | Queue management only               |

---

## 2. Universal Form Fields (Public, on Homepage)

### Donor Type & Identification

| Field                        | Type   | Notes                                      |
|------------------------------|--------|--------------------------------------------|
| Donor Type                   | select | Student / Employee / Representative        |
| Student ID                   | text   | required if Student                        |
| Employee ID                  | text   | required if Employee                       |
| Representative — Type        | select | Student / Employee (who they represent)    |
| Representative — ID Number   | text   | required if Representative                 |
| Representative — Full Name   | text   | required if Representative                 |

### Personal Information

| Field        | Type   |
|-------------|--------|
| Surname     | text   |
| Given Name  | text   |
| Middle Name | text   |
| Birthdate   | date   |
| Age         | number |
| Sex         | select |
| Civil Status| select |
| Blood Type  | select |
| Occupation  | text   |

### Address

| Field          | Type |
|----------------|------|
| House/Street   | text |
| Subdivision    | text |
| Barangay       | text |
| City/Province  | text |

### Contact & Academic

| Field          | Type   |
|----------------|--------|
| Email          | email  |
| Contact No.    | tel    |
| Course         | select |
| Year/Section   | text   |
| House of Heroes| select |

### Consent

- Checkbox: "I voluntarily give consent for collection and processing of my personal data."

---

## 3. Submission Flow

```
Student fills form → submits
       │
       ▼
System auto-assigns to hospital with least donors
       │
       ▼
System generates PDF using hospital's Blade template + dompdf
  - Personal info pre-filled
  - Medical section left blank for manual fill
       │
       ▼
Email sent to student with PDF attachment
       │
       ▼
Student prints PDF, manually fills medical section
       │
       ▼
Brings filled form on event day
```

### Hospital Auto-Assignment Logic

- Query count of registered donors per hospital
- Assign to hospital with fewest donors
- Ensures balanced distribution

---

## 4. PDF Generation

- **Library:** `barryvdh/laravel-dompdf`
- **Templates:** `resources/views/pdf-templates/{hospital_code}.blade.php`
- Each template is an HTML/CSS replica of that hospital's official PDF form
- System passes donor data to template → dompdf renders → PDF output
- Medical fields rendered as blank lines/blanks for manual fill

**Template location:**
```
resources/views/pdf-templates/
  vmc.blade.php       ← VMMC form layout
  pgh.blade.php       ← PGH form layout
  ...
```

---

## 5. Event Day — Queue Management (Staff)

### Check-In Flow

```
Student arrives at venue
       │
       ▼
Staff enters student/employee ID number
       │
       ▼
System looks up donor in database
       │
       ▼
Staff verifies identity
       │
       ▼
Queue number auto-assigned (format: {EventCode}-{3digit})
       │
       ▼
Donor appears on queue board as "waiting"
```

### Queue Control

| Action     | Effect                                                   |
|------------|----------------------------------------------------------|
| [Next]     | Current donor marked "in_progress", next in line called (email sent) |
| [Complete] | Donor marked completed                                   |
| [Skip]     | Donor moved to end or marked skipped                     |

### Queue Board Layout (Staff)

```
┌──────────────────────────────────────────────────────┐
│  📍 Gymnasium  |  🗓 Mar 25, 2026  |  🔴 Ongoing     │
├──────────────────────────────────────────────────────┤
│                                                      │
│  ▶ CURRENT:  #005  JUAN DELA CRUZ                    │
│       [✓ Complete]           [⏭ Skip]               │
│                                                      │
├──────────────────────────────────────────────────────┤
│  WAITING                                              │
│  ┌─────┬──────────────────────────┬─────────┬──────┐ │
│  │ #   │ Name / ID               │ Status  │ Next │ │
│  ├─────┼──────────────────────────┼─────────┼──────┤ │
│  │ 006 │ Maria Santos  — 2024-123 │ Waiting │ [▶]  │ │
│  │ 007 │ Pedro Reyes   — 2024-456 │ Waiting │ [▶]  │ │
│  │ 008 │ Ana Lopez     — 2024-789 │ Waiting │ [▶]  │ │
│  └─────┴──────────────────────────┴─────────┴──────┘ │
│                                                      │
├──────────────────────────────────────────────────────┤
│  CHECK IN NEW DONOR                                   │
│  [Enter ID Number...]                    [Assign #]   │
└──────────────────────────────────────────────────────┘
```

---

## 6. Email Notifications

| Trigger          | Content                                         |
|------------------|-------------------------------------------------|
| Form submitted   | "Your blood donation form" — PDF attached       |
| Queue called     | "Your turn is coming up — proceed to donation area" |

---

## 7. Database Schema

```
users (extends existing)
  - role: string (UserRole enum) — admin | staff

hospitals
  - id, name, code (VMC, PGH...)
  - timestamps

courses
  - id, name, department_id, timestamps

departments
  - id, name, timestamps

blood_donation_events
  - id, name, description, event_date, venue
  - status: string (EventStatus enum) — upcoming | ongoing | completed
  - timestamps

donors
  - id, tracking_code (unique)
  - donor_type: string (DonorType enum) — student | employee | representative
  - id_number (student or employee ID — for check-in)
  - full_name, email, contact_number
  - assigned_hospital_id
  - data (JSON) — all form personal info
  - status: string (DonorStatus enum) — registered | checked_in | in_progress | completed | skipped
  - timestamps

event_registrations
  - id, donor_id, event_id, hospital_id
  - queue_number
  - status: string (RegistrationStatus enum) — registered | checked_in | in_progress | completed | skipped | no_show
  - checked_in_by (user_id)
  - checked_in_at, called_at, completed_at
  - timestamps
```

---

## 8. Route Map

```
// Public
GET   /                          → Universal form (homepage)
POST  /register                  → Submit form

// Auth
GET   /login                     → Login page
POST  /login
POST  /logout

// Admin
GET   /admin/dashboard
GET   /admin/hospitals           → CRUD
GET   /admin/events              → CRUD
GET   /admin/events/{id}/donors  → Donor list per event
GET   /admin/donors              → All submissions
GET   /admin/courses             → Courses/departments
GET   /admin/users               → Staff accounts

// Staff
GET   /staff/queue               → Event selector
GET   /staff/events/{id}/queue   → Live queue
POST  /staff/events/{id}/checkin → Check in + queue number
POST  /staff/queue/{id}/next     → Call next
POST  /staff/queue/{id}/complete → Complete
POST  /staff/queue/{id}/skip     → Skip
```

---

## 9. Tech Stack

| Layer     | Technology                     |
|-----------|--------------------------------|
| Framework | Laravel 13                     |
| Frontend  | Inertia.js v3 + React 19       |
| Styling   | Tailwind CSS 4                 |
| PDF       | barryvdh/laravel-dompdf        |
| Database  | SQLite (configurable)          |
| Queue     | Laravel Queue (database)       |
| Mail      | Laravel Mail (log by default)  |
| Auth      | Session-based + Role middleware|

---

## 10. Implementation Phases

### Phase 1 — Foundation & Auth
- Add `role` column to `users` table
- Create `Department`, `Course`, `Hospital` models + migrations + seeders
- Build login page with Inertia React
- Role middleware for admin/staff separation

### Phase 2 — Universal Form (Public)
- `Donor`, `BloodDonationEvent`, `EventRegistration` models + migrations
- Multi-step universal form on homepage (personal info only)
- Auto-assign to hospital with least donors
- Install `barryvdh/laravel-dompdf`
- PDF generation service + per-hospital Blade templates
- Email PDF on submission

### Phase 3 — Admin Panel
- Dashboard with stats
- Hospital CRUD (name, code, address)
- Event CRUD
- Donor submissions list (filterable)
- Course/department management
- Staff user management

### Phase 4 — Staff Queue
- Queue dashboard — event selector
- Check-in: search by ID number → assign queue number
- Live queue board (current + waiting)
- Next / Complete / Skip controls
- Email notification on queue call

### Phase 5 — Polish
- Seeders for demo data
- Testing

---

## 11. Key Directories & Files

```
app/
  Enums/
    UserRole.php
    DonorType.php
    DonorStatus.php
    RegistrationStatus.php
    EventStatus.php
    BloodType.php
    Sex.php
    CivilStatus.php
    HouseOfHeroes.php
  Http/
    Controllers/
      PublicController.php       ← Form submission
      AuthController.php         ← Login/logout
      Admin/
        DashboardController.php
        HospitalController.php
        EventController.php
        DonorController.php
        CourseController.php
        UserController.php
      Staff/
        QueueController.php
    Middleware/
      RoleMiddleware.php
  Models/
    User.php (extend)
    Hospital.php
    Course.php
    Department.php
    Donor.php
    BloodDonationEvent.php
    EventRegistration.php
  Services/
    PdfGenerationService.php
    HospitalAssignmentService.php
  Mail/
    DonorFormMail.php

resources/
  views/
    pdf-templates/
      vmc.blade.php
      pgh.blade.php
      ...
  js/
    pages/
      welcome.tsx                 ← Universal form
      auth/
        login.tsx
      admin/
        dashboard.tsx
        hospitals/
          index.tsx
          form.tsx
        events/
          index.tsx
          form.tsx
          donors.tsx
        donors/
          index.tsx
        courses/
          index.tsx
        users/
          index.tsx
      staff/
        queue/
          index.tsx               ← Event selector
          event-queue.tsx         ← Live queue board
```

---

## 12. Key Design Decisions

1. **Donor `data` stored as JSON** — form is truly universal, no schema changes needed
2. **`id_number` as separate column** — fast lookup at staff check-in
3. **Hospital Blade templates** — you create HTML replicas of each hospital's PDF; dompdf converts to PDF
4. **Least-donors hospital assignment** — balanced distribution
5. **Queue number format** — `{EventCode}-{3digit}` (e.g., MAR25-001)
6. **Check-in by ID number** — works for students, employees, and representatives (rep uses the student/employee's ID)
7. **Enum fields as string columns + PHP backed enums + model casting** — all enum columns use `string` type in DB. Each has a PHP `BackedEnum` class with string values. Models cast them via `cast()` for type safety and clean code.
