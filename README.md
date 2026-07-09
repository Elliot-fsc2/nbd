# NCST Blood Donation Management System

A Laravel + Inertia React application for managing institutional blood donation drives. Students and employees fill a universal registration form online, get auto-assigned to a partner hospital, receive a pre-filled donation form PDF via email, and on event day staff manage the on-site queue through a live dashboard.

---

## Features

- **Public Registration Form** — Multi-step form collecting personal info, address, blood type, academic details, and House of Heroes affiliation
- **Hospital Auto-Assignment** — Distributes donors across partner hospitals using a least-donors algorithm
- **PDF Generation** — Generates hospital-specific partially-filled donation forms using dompdf + per-hospital Blade templates
- **Email Notification** — Sends the donation form PDF as an attachment on registration; sends queue-call notice when donor is next in line
- **Admin Panel** — Full CRUD for hospitals, events, courses, departments, and staff user management; donor list with detail dialog and form download
- **Staff Queue Dashboard** — Event selector → live queue board with check-in, call next, complete, and skip actions
- **TV Display** — Public-facing live queue display showing current serving donors, next-up, and waiting count
- **Role-Based Access** — Admin (full access), Staff (queue operations only)
- **Rate Limiting** — Public form submissions throttled to 3 per minute per IP

---

## Process Flow

```
┌─────────────────────────────────────────────────────────────────┐
│                    PRE-EVENT (Online)                           │
├─────────────────────────────────────────────────────────────────┤
│                                                                 │
│  Donor opens public registration form                           │
│         │                                                       │
│         ▼                                                       │
│  Fills multi-step form (personal info, address, blood type,     │
│  course, House of Heroes, consent)                              │
│         │                                                       │
│         ▼                                                       │
│  System auto-assigns hospital with fewest registered donors     │
│         │                                                       │
│         ▼                                                       │
│  System generates partially-filled PDF using hospital's         │
│  custom Blade template → dompdf renders                         │
│         │                                                       │
│         ▼                                                       │
│  Email sent to donor with PDF attachment                        │
│         │                                                       │
│         ▼                                                       │
│  Donor prints PDF, fills medical section manually               │
│                                                                 │
└─────────────────────────────────────────────────────────────────┘

┌─────────────────────────────────────────────────────────────────┐
│                      EVENT DAY (On-site)                        │
├─────────────────────────────────────────────────────────────────┤
│                                                                 │
│  Donor arrives at venue with printed form                       │
│         │                                                       │
│         ▼                                                       │
│  Staff enters donor's ID number → queue number assigned         │
│  Format: {EventPrefix}-{3digit} (e.g., BLO-001)                │
│         │                                                       │
│         ▼                                                       │
│  Donor appears on TV display and staff queue as "Waiting"       │
│         │                                                       │
│         ▼                                                       │
│  Staff clicks [Call] → donor moves to "In Progress"             │
│  Email notification sent: "Your turn is coming up"              │
│         │                                                       │
│         ▼                                                       │
│  Donor proceeds to donation area                                │
│         │                                                       │
│         ├── [Complete] → donor marked completed                 │
│         └── [Skip]    → donor moved to skipped                  │
│                                                                 │
└─────────────────────────────────────────────────────────────────┘
```

---

## Tech Stack

| Layer       | Technology                         |
|-------------|------------------------------------|
| Framework   | Laravel 13                         |
| Frontend    | Inertia.js v3 + React 19           |
| Styling     | Tailwind CSS 4                     |
| PDF         | barryvdh/laravel-dompdf            |
| Database    | SQLite (configurable to MySQL/pg)  |
| Queue       | Laravel Queue (database driver)    |
| Mail        | Laravel Mail (SMTP)                |
| Auth        | Session-based + Role middleware    |
| Types       | TypeScript (frontend)              |

---

## User Roles

| Role  | Access                                        |
|-------|-----------------------------------------------|
| Guest | Public registration form only                 |
| Staff | Queue management: check-in, call, complete    |
| Admin | Full CRUD: hospitals, events, courses, users  |

---

## Installation

```bash
git clone <repository>
cd ncst-blood-donation

# Backend
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate --seed

# Frontend
npm install
npm run build

# Queue worker (for email delivery)
php artisan queue:work
```

### Development

```bash
composer run dev
```

Starts Vite dev server + PHP dev server concurrently.

---

## Key Directories

```
app/
├── Enums/              → PHP backed enums (DonorType, DonorStatus, HouseOfHeroes...)
├── Http/Controllers/   → PublicController, AuthController, Admin/*, Staff/*
├── Mail/               → DonorFormMail, QueueCalledMail
├── Models/             → Donor, Hospital, BloodDonationEvent, EventRegistration...
└── Services/           → PdfGenerationService, HospitalAssignmentService

resources/
├── js/pages/           → Inertia React pages (welcome, admin/*, staff/*)
├── views/
│   ├── emails/         → Markdown email templates
│   └── pdf-templates/  → Hospital-specific PDF Blade templates (dompdf)

routes/
└── web.php             → All application routes
```

---

## Environment Variables

Key `.env` variables for production:

| Variable           | Description                          |
|--------------------|--------------------------------------|
| `APP_ENV`          | `production`                         |
| `APP_DEBUG`        | `false`                              |
| `APP_KEY`          | Generate via `php artisan key:generate` |
| `APP_URL`          | Production URL                       |
| `DB_CONNECTION`    | `sqlite`, `mysql`, or `pgsql`        |
| `MAIL_MAILER`      | `smtp`                               |
| `MAIL_HOST`        | SMTP server                          |
| `MAIL_FROM_ADDRESS`| Sender email (`nbd@ncst.edu.ph`)     |
| `QUEUE_CONNECTION` | `database`                           |
