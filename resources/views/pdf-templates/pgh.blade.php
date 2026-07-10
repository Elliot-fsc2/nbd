<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <style>
        @page { margin: 0.4in 0.6in 0.4in 0.5in; }
        body { background: #fff; color: #000; font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; font-size: 10px; margin: 0; padding: 0; }

        .page {
            background: #fff;
            position: relative;
        }
        .page-break {
            page-break-before: always;
            margin-top: 20px;
            border-top: 1px dashed #ccc;
            padding-top: 20px;
        }
        @media print {
            body { padding: 0; }
            .page-break { page-break-before: always; border-top: none; padding-top: 0; margin-top: 0; }
        }

        /* Typography & Utility classes */
        .text-7 { font-size: 7.5px; }
        .text-8 { font-size: 8px; }
        .text-9 { font-size: 9px; }
        .text-10 { font-size: 10px; }
        .text-11 { font-size: 11px; }
        .text-12 { font-size: 12px; }
        .text-14 { font-size: 14px; }
        .text-17 { font-size: 17px; }

        .bold { font-weight: bold; }
        .bolder { font-weight: 800; }
        .boldest { font-weight: 900; }
        .italic { font-style: italic; }
        .uppercase { text-transform: uppercase; }
        .underline { text-decoration: underline; }
        .text-center { text-align: center; }
        .text-right { text-align: right; }
        .text-blue { color: #000000; } /* Set to standard clean black/monochrome to match B&W form specification */

        /* Borders and lines */
        .border-b { border-bottom: 1px solid #000; }
        .border-t { border-top: 1px solid #000; }
        .border-2b { border-bottom: 2px solid #000; }
        .border-2t { border-top: 2px solid #000; }
        .border { border: 1px solid #000; }

        .inline { display: inline-block; }
        .block { display: block; }
        .w-full { width: 100%; }

        /* Spacing utilities */
        .mt-1 { margin-top: 4px; }
        .mt-2 { margin-top: 8px; }
        .mt-3 { margin-top: 12px; }
        .mt-4 { margin-top: 16px; }
        .mt-5 { margin-top: 20px; }
        .mt-6 { margin-top: 24px; }
        .mb-1 { margin-bottom: 4px; }
        .mb-2 { margin-bottom: 8px; }
        .mb-3 { margin-bottom: 12px; }
        .mb-4 { margin-bottom: 16px; }
        .mb-0 { margin-bottom: 0; }
        .ml-1 { margin-left: 4px; }
        .ml-2 { margin-left: 8px; }
        .ml-4 { margin-left: 16px; }
        .ml-16 { margin-left: 64px; }
        .mr-4 { margin-right: 16px; }

        .pb-1 { padding-bottom: 4px; }
        .pt-1 { padding-top: 4px; }
        .pt-2 { padding-top: 8px; }
        .pl-2 { padding-left: 8px; }
        .pr-2 { padding-right: 8px; }
        .py-1 { padding-top: 4px; padding-bottom: 4px; }
        .py-2 { padding-top: 8px; padding-bottom: 8px; }
        .px-2 { padding-left: 8px; padding-right: 8px; }

        .leading-tight { line-height: 1.2; }
        .leading-snug { line-height: 1.4; }
        .leading-normal { line-height: 1.6; }

        /* Table Layout Architecture */
        table { border-collapse: collapse; width: 100%; margin: 0; padding: 0; }
        td, th { vertical-align: top; padding: 0; }

        /* Form Specific UI elements */
        .checkbox { display: inline-block; width: 11px; height: 11px; border: 1px solid #000; vertical-align: middle; margin-right: 4px; }
        .circle-box { display: inline-block; width: 14px; height: 14px; border-radius: 50%; border: 1px solid #000; vertical-align: middle; text-align: center; }
        .fill-line { border-bottom: 1px solid #000; display: inline-block; }
        .sub-label { display: block; font-size: 7.5px; font-style: italic; text-align: center; margin-top: 2px; color: #333; }

        /* Questionnaire table structure */
        .q-table td { padding: 3px 2px; vertical-align: middle; }
        .q-num { font-weight: bold; width: 20px; vertical-align: top; padding-top: 3px; }
        .q-text { padding-left: 4px; line-height: 1.3; }
        .q-header { background-color: #f2f2f2; border: 1px solid #000; }
    </style>
</head>
<body>

{{-- PAGE 1 --}}
<div class="page">

    {{-- HEADER --}}
    <table class="mb-2 border-b" style="padding-bottom: 6px;">
        <tr>
            <td style="width: 68%; vertical-align: top;">
                <p class="bold text-9 mb-1" style="margin: 0 0 2px 0;">PGH Form No. P-360037</p>
                <p class="text-7" style="margin: 0 0 6px 0;">Rev. 03, Eff. Date 28 April 2025</p>
                <table style="width: 100%;">
                    <tr>
                        <td style="width: 55px; vertical-align: middle;">
                            <img src="{{ public_path('images/UP.png') }}" alt="UP Seal" style="height: 52px; width: auto; display: block;" />
                        </td>
                        <td style="width: 55px; vertical-align: middle; padding-left: 4px;">
                            <img src="{{ public_path('images/pgh.png') }}" alt="PGH Logo" style="height: 52px; width: auto; display: block;" />
                        </td>
                        <td style="padding-left: 10px; vertical-align: middle;">
                            <p class="bold text-10 uppercase" style="letter-spacing: -0.2px; margin: 0; line-height: 1.2;">Department of Laboratories &ndash; Division of Blood Bank</p>
                            <p class="boldest text-17 uppercase" style="letter-spacing: 0.2px; line-height: 1.1; margin: 2px 0;">UP &ndash; Philippine General Hospital</p>
                            <p class="text-8" style="margin: 0; line-height: 1.3; color: #222;">2<sup>nd</sup> Floor, Central Block Building, UP-PGH, Taft Avenue, Manila 1000</p>
                            <p class="text-8" style="margin: 0; line-height: 1.3; color: #222;">Tel. (632) 85548400 Local 3214/3017 | Email: bloodbank.uppgh@up.edu.ph</p>
                        </td>
                    </tr>
                </table>
            </td>
            <td style="width: 32%; vertical-align: top; padding-left: 12px; border-left: 1px solid #ddd;">
                <p class="bold text-10 uppercase" style="margin: 0 0 4px 0; border-bottom: 1px solid #000; padding-bottom: 2px;">Date: <span class="fill-line" style="width: 70%;">&nbsp;</span></p>
                @foreach (['Arrival', 'Interview', 'P.E.', 'Extraction', 'Bleed', 'Serology'] as $field)
                <table style="margin-bottom: 2px;">
                    <tr>
                        <td style="width: 60px; text-align: right; font-weight: bold; font-size: 9px; padding-right: 6px; vertical-align: middle;">{{ $field }}</td>
                        <td style="border-bottom: 1px solid #000; width: 110px; height: 15px;">&nbsp;</td>
                    </tr>
                </table>
                @endforeach
                <p class="text-7 italic mt-1 text-center" style="margin-top: 3px; color: #444;">( Indicate time and MTOD initials )</p>
            </td>
        </tr>
    </table>

    {{-- STAFF / BLOOD TYPE SECTION --}}
    <table class="border" style="padding: 6px; margin-bottom: 10px; background-color: #fafafa;">
        <tr>
            <td style="width: 48%; vertical-align: top; padding: 4px 8px;">
                <p class="italic text-9 bold" style="margin: 0 0 6px 0; color: #111;">(This section is for Blood Bank staff only)</p>
                <p class="mt-1 text-10 bold" style="margin: 4px 0;">Tube no. <span class="fill-line" style="width: 140px; margin-left: 4px;">&nbsp;</span></p>
                <p class="mt-2 text-10 bold" style="margin: 8px 0 4px 0;">ID type <span class="fill-line" style="width: 145px; margin-left: 4px;">&nbsp;</span></p>
            </td>
            <td style="width: 52%; vertical-align: top; padding: 4px 8px; border-left: 1px solid #ccc;">
                <table style="width: 100%;">
                    <tr>
                        <td class="bold text-10" style="padding: 2px 0;">Blood Type:</td>
                        <td style="border-bottom: 1px solid #000; width: 100px;">&nbsp;</td>
                        <td class="bold text-10" style="padding: 2px 0; padding-left: 12px;">Rh:</td>
                        <td style="border-bottom: 1px solid #000; width: 60px;">&nbsp;</td>
                    </tr>
                </table>
                <table style="margin-top: 5px; width: 100%;">
                    <tr>
                        <td class="bold text-10" style="padding: 2px 0; width: 120px;">US Grading<sup>p</sup> / MTOD:</td>
                        <td style="border-bottom: 1px solid #000;">&nbsp;</td>
                    </tr>
                </table>
                <table style="margin-top: 5px; width: 100%;">
                    <tr>
                        <td class="bold text-10" style="padding: 2px 0; width: 120px;">DS Grading / MTOD:</td>
                        <td style="border-bottom: 1px solid #000;">&nbsp;</td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>

    @php
    $p = $data['personal'] ?? [];
    $surname = $p['surname'] ?? '';
    $firstName = $p['first_name'] ?? '';
    $middleName = $p['middle_name'] ?? '';
    $age = $p['age'] ?? '';
    $gender = $p['gender'] ?? '';
    $birthdate = !empty($p['birthdate']) ? \Carbon\Carbon::parse($p['birthdate'])->format('m/d/Y') : '';
    $birthplace = $p['birthplace'] ?? '';
    $civilStatus = $p['civil_status'] ?? '';
    $nationality = $p['nationality'] ?? '';
    $houseNo = $p['house_no'] ?? '';
    $street = $p['street'] ?? '';
    $subdivision = $p['subdivision'] ?? '';
    $barangay = $p['barangay'] ?? '';
    $city = $p['city'] ?? '';
    $province = $p['province'] ?? '';
    $zipCode = $p['zip_code'] ?? '';
    $telephone = $p['telephone'] ?? '';
    $occupation = $p['occupation'] ?? '';
    $donationCount = $p['donation_count'] ?? '';
    $lastDonationDetails = $p['last_donation_details'] ?? '';
    $patientName = $p['patient_name'] ?? '';
    $caseNo = $p['case_no'] ?? '';
    $deptWard = $p['dept_ward'] ?? '';
    $relationship = $p['relationship'] ?? '';
    @endphp

    {{-- BLOOD DONOR FORM CLIENT SECTION --}}
    <div class="border" style="padding: 8px; padding-top: 4px; background-color: #fff;">
        <p class="italic text-9 bold" style="margin: 0 0 4px 0;">(For Donors, please accomplish this portion)</p>

        <div class="text-center mb-2">
            <p class="boldest text-14 uppercase" style="letter-spacing: 0.5px; margin: 0 0 2px 0;">Blood Donor Form</p>
            <p class="bold text-10" style="margin: 0;">(English)</p>
        </div>

        {{-- Category --}}
        <table style="margin: 4px auto 10px auto; width: auto;">
            <tr>
                <td class="bold text-10" style="padding-right: 15px; vertical-align: middle;">Category:</td>
                <td style="padding-right: 20px; vertical-align: middle;"><span class="checkbox"></span> Pre-deposit</td>
                <td style="padding-right: 20px; vertical-align: middle;"><span class="checkbox"></span> Walk-in Donor</td>
                <td style="vertical-align: middle;"><span class="checkbox"></span> Mobile blood drive</td>
            </tr>
        </table>

        {{-- Name row --}}
        <table style="margin-bottom: 6px; table-layout: fixed;">
            <tr>
                <td class="bold text-10" style="width: 55px; vertical-align: bottom;">Surname:</td>
                <td style="border-bottom: 1px solid #000; padding-left: 4px; vertical-align: bottom; font-size: 11px;">{{ $surname }}</td>
                <td class="bold text-10" style="width: 65px; text-align: right; padding-right: 6px; vertical-align: bottom;">First name:</td>
                <td style="border-bottom: 1px solid #000; padding-left: 4px; vertical-align: bottom; font-size: 11px;">{{ $firstName }}</td>
                <td class="bold text-10" style="width: 80px; text-align: right; padding-right: 6px; vertical-align: bottom;">Middle name:</td>
                <td style="border-bottom: 1px solid #000; padding-left: 4px; vertical-align: bottom; font-size: 11px;">{{ $middleName }}</td>
            </tr>
        </table>

        {{-- Age / Sex / Birthdate / Civil Status / Nationality --}}
        <table style="margin-bottom: 6px;">
            <tr>
                <td class="bold text-10" style="width: 55px; vertical-align: bottom;">Age/Sex:</td>
                <td style="border-bottom: 1px solid #000; width: 55px; text-align: center; vertical-align: bottom;">{{ $age }} / {{ $gender }}</td>
                <td class="bold text-10" style="width: 125px; text-align: right; padding-right: 6px; vertical-align: bottom;">Date and Place of Birth:</td>
                <td style="width: 115px; vertical-align: bottom;">
                    <span style="border-bottom: 1px solid #000; display: block; text-align: center; padding-bottom: 1px;">{{ $birthdate }}</span>
                    <span class="sub-label">Date (mm/dd/yyyy)</span>
                </td>
                <td style="width: 4px;"></td>
                <td style="vertical-align: bottom;">
                    <span style="border-bottom: 1px solid #000; display: block; text-align: center; padding-bottom: 1px;">{{ $birthplace }}</span>
                    <span class="sub-label">Place</span>
                </td>
                <td class="bold text-10" style="width: 70px; text-align: right; padding-right: 4px; vertical-align: bottom;">Civil Status:</td>
                <td style="border-bottom: 1px solid #000; width: 65px; text-align: center; vertical-align: bottom;">{{ $civilStatus }}</td>
                <td class="bold text-10" style="width: 65px; text-align: right; padding-right: 4px; vertical-align: bottom;">Nationality:</td>
                <td style="border-bottom: 1px solid #000; width: 75px; text-align: center; vertical-align: bottom;">{{ $nationality }}</td>
            </tr>
        </table>

        {{-- Complete Permanent Address --}}
        <div style="margin-bottom: 6px; border: 1px dashed #ccc; padding: 6px; background-color: #fdfdfd;">
            <table style="width: 100%;">
                <tr>
                    <td class="bold text-10" style="width: 155px; vertical-align: middle;">Complete Permanent Address:</td>
                    <td style="width: 80px; padding: 0 2px;">
                        <span style="border-bottom: 1px solid #000; display: block; text-align: center; min-height: 14px;">{{ $houseNo }}</span>
                        <span class="sub-label">House No.</span>
                    </td>
                    <td style="padding: 0 2px;">
                        <span style="border-bottom: 1px solid #000; display: block; text-align: center; min-height: 14px;">{{ $street }}</span>
                        <span class="sub-label">Lot &amp; Block no. / Street</span>
                    </td>
                    <td style="width: 180px; padding: 0 2px;">
                        <span style="border-bottom: 1px solid #000; display: block; text-align: center; min-height: 14px;">{{ $subdivision }}</span>
                        <span class="sub-label">Subdivision/Townhouse</span>
                    </td>
                </tr>
            </table>
            <table style="margin-top: 4px; width: 100%;">
                <tr>
                    <td style="width: 25%; padding: 0 2px;">
                        <span style="border-bottom: 1px solid #000; display: block; text-align: center; min-height: 14px;">{{ $barangay }}</span>
                        <span class="sub-label">Barangay / Sitio</span>
                    </td>
                    <td style="width: 30%; padding: 0 2px;">
                        <span style="border-bottom: 1px solid #000; display: block; text-align: center; min-height: 14px;">{{ $city }}</span>
                        <span class="sub-label">City / Municipality</span>
                    </td>
                    <td style="width: 30%; padding: 0 2px;">
                        <span style="border-bottom: 1px solid #000; display: block; text-align: center; min-height: 14px;">{{ $province }}</span>
                        <span class="sub-label">Province</span>
                    </td>
                    <td style="width: 15%; padding: 0 2px;">
                        <span style="border-bottom: 1px solid #000; display: block; text-align: center; min-height: 14px;">{{ $zipCode }}</span>
                        <span class="sub-label">ZIP Code</span>
                    </td>
                </tr>
            </table>
        </div>

        {{-- Tel / Occupation --}}
        <table style="margin-bottom: 6px;">
            <tr>
                <td class="bold text-10" style="width: 70px; vertical-align: bottom;">Tel./Cel. #:</td>
                <td style="border-bottom: 1px solid #000; vertical-align: bottom;">{{ $telephone }}</td>
                <td class="bold text-10" style="width: 80px; text-align: right; padding-right: 6px; vertical-align: bottom;">Occupation:</td>
                <td style="border-bottom: 1px solid #000; vertical-align: bottom;">{{ $occupation }}</td>
            </tr>
        </table>

        {{-- Donation history --}}
        <table style="margin-bottom: 6px;">
            <tr>
                <td class="bold text-10" style="width: 230px; vertical-align: bottom;">How many times have you donated blood?</td>
                <td style="border-bottom: 1px solid #000; width: 80px; text-align: center; vertical-align: bottom;">{{ $donationCount }}</td>
                <td class="bold text-10" style="text-align: right; padding-right: 6px; vertical-align: bottom;">Date &amp; Place of last donation:</td>
                <td style="border-bottom: 1px solid #000; width: 250px; vertical-align: bottom;">{{ $lastDonationDetails }}</td>
            </tr>
        </table>

        {{-- Patient info --}}
        <table style="margin-bottom: 6px;">
            <tr>
                <td class="bold text-10" style="width: 100px; vertical-align: bottom;">Name of Patient:</td>
                <td style="border-bottom: 1px solid #000; vertical-align: bottom;">{{ $patientName }}</td>
                <td class="bold text-10" style="width: 55px; text-align: right; padding-right: 6px; vertical-align: bottom;">Case #:</td>
                <td style="border-bottom: 1px solid #000; width: 120px; vertical-align: bottom;">{{ $caseNo }}</td>
                <td class="bold text-10" style="width: 80px; text-align: right; padding-right: 6px; vertical-align: bottom;">Dept./Ward:</td>
                <td style="border-bottom: 1px solid #000; width: 140px; vertical-align: bottom;">{{ $deptWard }}</td>
            </tr>
        </table>

        {{-- Relationship --}}
        <table style="margin-bottom: 2px;">
            <tr>
                <td class="bold text-10" style="width: 145px; vertical-align: bottom;">Relationship to the patient:</td>
                <td style="border-bottom: 1px solid #000; vertical-align: bottom;">{{ $relationship }}</td>
            </tr>
        </table>
    </div>

    {{-- QUESTIONNAIRE PART 1 --}}
    <div class="mt-2 text-10">
        <p class="bold mb-1" style="font-size: 10.5px;">Instructions: Place a check (<span style="font-family: Arial, sans-serif;">&#10003;</span>):</p>

        <table class="q-table" style="width: 100%; border: 1px solid #000;">
            <thead>
                <tr class="q-header">
                    <th style="width: 45px; text-align: center; border-right: 1px solid #000; padding: 4px 0;" class="bold text-10">YES</th>
                    <th style="width: 45px; text-align: center; border-right: 1px solid #000; padding: 4px 0;" class="bold text-10">NO</th>
                    <th style="text-align: left; padding: 4px 8px;" class="bold text-10">Are you&hellip;</th>
                </tr>
            </thead>
            <tbody>

            @php
            $circle = '<span class="circle-box">&nbsp;</span>';
            @endphp

            @foreach ([[1, 'Feeling healthy today?<br>Have you ever had any significant illnesses, or diseases from the attached list? *'], [2, 'Currently taking medication?<br>Have you taken any medication or substance(s) from the deferral list? *'], [3, 'Have you received any vaccination?'], [4, 'Have you taken aspirin or anything that has aspirin on it?'], [5, 'For females: In the past 9 months, have you been pregnant or had given birth?<br>Or have you breastfed for the past 3 months, or are currently breast feeding?']] as [$num, $question])
                <tr style="border-bottom: 1px solid #eee;">
                    <td style="text-align: center; border-right: 1px solid #000;">{!! $circle !!}</td>
                    <td style="text-align: center; border-right: 1px solid #000;">{!! $circle !!}</td>
                    <td class="q-text"><span class="q-num">{{ $num }}.</span> {!! $question !!}</td>
                </tr>
            @endforeach
            </tbody>
        </table>

        <table style="margin: 4px 0 8px 90px; width: auto;">
            <tr>
                <td class="bold text-9" style="white-space: nowrap; padding: 0; vertical-align: bottom;">Last Menstrual Period:</td>
                <td style="border-bottom: 1px solid #000; width: 160px; height: 16px; vertical-align: bottom;">&nbsp;</td>
            </tr>
        </table>

        {{-- Section 12 weeks --}}
        <table class="q-table" style="width: 100%; border: 1px solid #000; border-top: none; margin-top: -4px;">
            <thead>
                <tr style="background-color: #fafdff; border-bottom: 1px solid #000;">
                    <th style="width: 45px; border-right: 1px solid #000;"></th>
                    <th style="width: 45px; border-right: 1px solid #000;"></th>
                    <th style="text-align: left; padding: 3px 6px;" class="bold text-9 uppercase italic">In the past 12 weeks have you&hellip;</th>
                </tr>
            </thead>
            <tbody>
                <tr style="border-bottom: 1px solid #000;">
                    <td style="text-align: center; border-right: 1px solid #000; padding: 4px 0;">{!! $circle !!}</td>
                    <td style="text-align: center; border-right: 1px solid #000; padding: 4px 0;">{!! $circle !!}</td>
                    <td class="q-text"><span class="q-num">6.</span> Donated blood, platelet or plasma?</td>
                </tr>
            </tbody>
        </table>

        {{-- Section 12 months --}}
        <table class="q-table" style="width: 100%; border: 1px solid #000; border-top: none; margin-top: 4px;">
            <thead>
                <tr style="background-color: #fafdff; border-bottom: 1px solid #000;">
                    <th style="width: 45px; border-right: 1px solid #000;"></th>
                    <th style="width: 45px; border-right: 1px solid #000;"></th>
                    <th style="text-align: left; padding: 3px 6px;" class="bold text-9 uppercase italic">In the past 12 months have you&hellip;</th>
                </tr>
            </thead>
            <tbody>
            @foreach ([[7, 'Had a blood transfusion?'], [8, 'Had surgical operation, dental extraction, or any major medical procedure? *'], [9, 'Had a tattoo, ear or body piercing, accidental contact with blood, needlestick injury, and acupuncture?'], [10, 'Had sexual contact with high-risk individuals? *'], [11, 'Had sexual contact with anyone in exchange for material or monetary gain?'], [12, 'Had sexual contact with a person who has worked abroad?'], [13, 'Engaged in casual sex?'], [14, 'Lived with a person who has hepatitis?'], [15, 'Have you been imprisoned?'], [16, 'Have any of your relatives had Creutzfeldt-Jacob (Mad Cow) disease?']] as [$num, $question])
                <tr style="border-bottom: 1px solid #eee;">
                    <td style="text-align: center; border-right: 1px solid #000;">{!! $circle !!}</td>
                    <td style="text-align: center; border-right: 1px solid #000;">{!! $circle !!}</td>
                    <td class="q-text"><span class="q-num">{{ $num }}.</span> {{ $question }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>

        {{-- Section Have you ever --}}
        <table class="q-table" style="width: 100%; border: 1px solid #000; border-top: none; margin-top: 4px;">
            <thead>
                <tr style="background-color: #fafdff; border-bottom: 1px solid #000;">
                    <th style="width: 45px; border-right: 1px solid #000;"></th>
                    <th style="width: 45px; border-right: 1px solid #000;"></th>
                    <th style="text-align: left; padding: 3px 6px;" class="bold text-9 uppercase italic">Have you ever&hellip;</th>
                </tr>
            </thead>
            <tbody>
            @foreach ([[17, 'Lived outside your place of residence, or had any history of travel?'], [18, 'Lived or traveled outside the Philippines?']] as [$num, $question])
                <tr style="border-bottom: 1px solid #eee;">
                    <td style="text-align: center; border-right: 1px solid #000; padding: 4px 0;">{!! $circle !!}</td>
                    <td style="text-align: center; border-right: 1px solid #000; padding: 4px 0;">{!! $circle !!}</td>
                    <td class="q-text"><span class="q-num">{{ $num }}.</span> {{ $question }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</div>

{{-- PAGE 2 --}}
<div class="page page-break">

    {{-- QUESTIONNAIRE PART 2 --}}
    <div class="text-10">
        <table class="q-table" style="width: 100%; border: 1px solid #000;">
            <thead>
                <tr class="q-header">
                    <th style="width: 45px; text-align: center; border-right: 1px solid #000; padding: 4px 0;" class="bold text-10">YES</th>
                    <th style="width: 45px; text-align: center; border-right: 1px solid #000; padding: 4px 0;" class="bold text-10">NO</th>
                    <th style="text-align: left; padding: 4px 8px;" class="bold text-10">Have you ever&hellip; (Continued)</th>
                </tr>
            </thead>
            <tbody>
            @foreach ([[19, 'Used needles to take drugs, steroids or anything not prescribed by your doctor?'], [20, 'Used clotting factor concentrates?'], [21, 'Had a positive test for the HIV virus, Hepatitis virus, Syphilis or Malaria?'], [22, 'Had Hepatitis?'], [23, 'Had Malaria?'], [24, 'Been told to have or treated for genital wart, syphilis, gonorrhea, or other Sexually transmissible Infections?'], [25, 'Had any type of cancer, for example Leukemia?'], [26, 'Had any problems with your heart and lungs?'], [27, 'Had a bleeding condition or a blood disease?'], [28, 'Are you giving blood because you wanted to be tested for HIV or Hepatitis virus?'], [29, 'Are you aware that if you have the HIV/Hepatitis virus, you can give it to someone else though you may feel well and have a negative HIV/Hepatitis test?']] as [$num, $question])
                <tr style="border-bottom: 1px solid #eee;">
                    <td style="text-align: center; border-right: 1px solid #000; padding: 4px 0;">{!! $circle !!}</td>
                    <td style="text-align: center; border-right: 1px solid #000; padding: 4px 0;">{!! $circle !!}</td>
                    <td class="q-text"><span class="q-num">{{ $num }}.</span> {{ $question }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>

        <p class="italic text-9 mt-2 mb-3" style="color: #333; padding-left: 4px;">Note: Questions with an asterisk (*) will be further explained by the interviewer.</p>

        {{-- DONOR'S INFORMED CONSENT --}}
        <div class="mb-3 border" style="padding: 10px; background-color: #fafafa; border-radius: 4px;">
            <p class="bold text-11 text-center mb-2" style="letter-spacing: 0.5px; border-bottom: 1px solid #ddd; padding-bottom: 4px;">DONOR'S INFORMED CONSENT</p>

            <p class="mb-2 leading-snug style-paragraph" style="text-align: justify; text-indent: 20px;">
                &ldquo;I, <span class="fill-line" style="width: 250px;">&nbsp;</span>, certify that I am the person referred to in all the entries, which were read and well understood by me. It is my free and voluntary act to donate my blood, aware of its risks during and after extraction. The same have been explained to me in understandable language and dialect that I speak.&rdquo;
            </p>

            <p class="mb-2 leading-snug" style="text-align: justify; text-indent: 20px;">
                I am voluntarily giving my blood through the Philippine General Hospital Blood Bank. I understand that my blood will be tested for Blood Type, Hemoglobin, Malaria, Syphilis, Hepatitis B, Hepatitis C and HIV and no official result will be released to me. If the result is reactive, I agree to be referred to the appropriate facility for counseling and further management.
            </p>

            <p class="bold mb-1" style="margin-top: 6px;">For platelet donation only (Platelet Pheresis):</p>
            <p class="mb-3 leading-snug" style="text-align: justify;">
                I understand that donating platelets involves undergoing the apheresis process, where my blood will be filtered through a machine that separates only the platelets. I acknowledge that I am aware of the potential risks associated with both the collection process and the period following the procedure.
            </p>

            <p class="bold text-center my-3 leading-snug" style="font-size: 10.5px; margin: 12px 0;">&ldquo;I certify that I have to the best of my knowledge, truthfully answered the above questions.&rdquo;</p>

            <table class="mt-6" style="margin-top: 30px; width: 100%;">
                <tr>
                    <td style="width: 45%; text-align: center;">
                        <span style="border-top: 1px solid #000; display: block; padding-top: 4px; width: 85%; margin: 0 auto;" class="text-9 bold">Signature over printed name of Donor</span>
                    </td>
                    <td style="width: 10%;"></td>
                    <td style="width: 45%; text-align: center;">
                        <span style="border-top: 1px solid #000; display: block; padding-top: 4px; width: 85%; margin: 0 auto;" class="text-9 bold">Signature of Interviewer</span>
                    </td>
                </tr>
            </table>
        </div>
    </div>

    {{-- PHYSICAL EXAMINATION --}}
    <div class="mt-4 border-2t pt-2 text-10">
        <p class="italic text-9 bold" style="margin: 0 0 2px 0; color: #222;">(This section is for Blood Bank staff only)</p>
        <p class="bold text-11 uppercase" style="margin: 2px 0 4px 0; letter-spacing: 0.3px;">PHYSICAL EXAMINATION:</p>
        <p class="italic text-8" style="margin: 0 0 8px 0; color: #444;">(NOTE: Please indicate time of P.E. in front of the form)</p>

        <table class="mb-2" style="width: 100%;">
            <tr>
                <td class="bold" style="white-space: nowrap; width: 50px; vertical-align: middle;">Weight:</td>
                <td style="border-bottom: 1px solid #000; width: 100px;">&nbsp;</td>
                <td class="bold" style="white-space: nowrap; width: 30px; padding-left: 4px; vertical-align: middle;">kg.</td>
                <td class="bold" style="padding-left: 15px; white-space: nowrap; width: 100px; vertical-align: middle;">Blood Pressure:</td>
                <td style="border-bottom: 1px solid #000; width: 120px;">&nbsp;</td>
                <td class="bold" style="padding-left: 15px; white-space: nowrap; width: 45px; vertical-align: middle;">Temp:</td>
                <td style="border-bottom: 1px solid #000; width: 80px;">&nbsp;</td>
                <td class="bold" style="padding-left: 15px; white-space: nowrap; width: 30px; vertical-align: middle;">HR:</td>
                <td style="border-bottom: 1px solid #000;">&nbsp;</td>
            </tr>
        </table>

        <table style="margin-bottom: 6px; width: 100%;">
            <tr>
                <td class="bold" style="white-space: nowrap; width: 120px; padding: 4px 0; vertical-align: bottom;">General Appearance:</td>
                <td style="border-bottom: 1px solid #000; padding: 4px 0; vertical-align: bottom;">&nbsp;</td>
                <td class="bold" style="padding-left: 15px; white-space: nowrap; width: 105px; padding: 4px 0; vertical-align: bottom;">Skin/Extremities:</td>
                <td style="border-bottom: 1px solid #000; padding: 4px 0; vertical-align: bottom;">&nbsp;</td>
            </tr>
            <tr>
                <td class="bold" style="white-space: nowrap; width: 120px; padding: 4px 0; vertical-align: bottom;">HEENT:</td>
                <td style="border-bottom: 1px solid #000; padding: 4px 0; vertical-align: bottom;">&nbsp;</td>
                <td class="bold" style="padding-left: 15px; white-space: nowrap; width: 105px; padding: 4px 0; vertical-align: bottom;">Heart and Lungs:</td>
                <td style="border-bottom: 1px solid #000; padding: 4px 0; vertical-align: bottom;">&nbsp;</td>
            </tr>
        </table>

        <table style="margin-bottom: 6px; width: 100%; background-color: #fcfcfc; border: 1px dashed #ccc; padding: 6px;">
            <tr>
                <td class="bold" style="white-space: nowrap; width: 65px; vertical-align: middle;">Remarks:</td>
                <td style="vertical-align: middle; width: 120px;"><span class="checkbox"></span> Accepted</td>
                <td style="vertical-align: middle; width: 180px;"><span class="checkbox"></span> Temporarily Deferred</td>
                <td style="vertical-align: middle;"><span class="checkbox"></span> Permanently Deferred</td>
            </tr>
        </table>

        <table style="margin-bottom: 10px; width: 100%;">
            <tr>
                <td class="bold" style="white-space: nowrap; width: 120px; vertical-align: bottom;">Reason/s for Deferral:</td>
                <td style="border-bottom: 1px solid #000; vertical-align: bottom;">&nbsp;</td>
            </tr>
        </table>

        <table style="margin-top: 15px; margin-left: auto; width: auto;">
            <tr>
                <td style="width: 320px; text-align: center;">
                    <br />
                    <span style="border-top: 1px solid #000; display: block; padding-top: 4px;" class="text-9 bold">Signature over Printed Name of Medical Officer</span>
                </td>
            </tr>
        </table>
    </div>

    {{-- LABORATORY EXAMS --}}
    <div class="border-2t pt-2 mt-3 text-10">
        <p class="boldest underline mb-2" style="font-size: 10.5px; letter-spacing: 0.2px;">LABORATORY EXAMS FOR PROCESSING OF BLOOD DONORS:</p>

        <table style="margin-bottom: 6px; width: 100%; table-layout: fixed;">
            <tr>
                <td class="bold" style="white-space: nowrap; width: 80px; vertical-align: bottom; padding: 2px 0;">Hemoglobin:</td>
                <td style="border-bottom: 1px solid #000; vertical-align: bottom;">&nbsp;</td>
                <td class="bold" style="padding-left: 15px; white-space: nowrap; width: 70px; vertical-align: bottom; padding: 2px 0;">HBsAg:</td>
                <td style="border-bottom: 1px solid #000; vertical-align: bottom;">&nbsp;</td>
                <td class="bold" style="padding-left: 15px; white-space: nowrap; width: 55px; vertical-align: bottom; padding: 2px 0;">TPA:</td>
                <td style="border-bottom: 1px solid #000; vertical-align: bottom;">&nbsp;</td>
                <td class="bold" style="padding-left: 15px; white-space: nowrap; width: 70px; vertical-align: bottom; padding: 2px 0;">Malaria:</td>
                <td style="border-bottom: 1px solid #000; vertical-align: bottom;">&nbsp;</td>
            </tr>
            <tr>
                <td class="bold" style="white-space: nowrap; width: 80px; vertical-align: bottom; padding: 6px 0 2px 0;">Hct:</td>
                <td style="border-bottom: 1px solid #000; vertical-align: bottom;">&nbsp;</td>
                <td class="bold" style="padding-left: 15px; white-space: nowrap; width: 70px; vertical-align: bottom; padding: 6px 0 2px 0;">HCV:</td>
                <td style="border-bottom: 1px solid #000; vertical-align: bottom;">&nbsp;</td>
                <td class="bold" style="padding-left: 15px; white-space: nowrap; width: 55px; vertical-align: bottom; padding: 6px 0 2px 0;">HIV:</td>
                <td style="border-bottom: 1px solid #000; vertical-align: bottom;">&nbsp;</td>
                <td colspan="2"></td>
            </tr>
        </table>

        <table style="margin-top: 20px; margin-left: auto; width: auto;">
            <tr>
                <td style="width: 320px; text-align: center;">
                    <br />
                    <span style="border-top: 1px solid #000; display: block; padding-top: 4px;" class="text-9 bold">Signature over Printed Name of Med. Tech. on Duty</span>
                </td>
            </tr>
        </table>
    </div>

</div>
</body>
</html>
