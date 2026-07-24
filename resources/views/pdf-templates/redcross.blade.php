<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8" />
        <style>
            @page { size: 8.5in 13in; margin: 12px 16px; }
            * {
                box-sizing: border-box;
            }
            body {
                background: #fff;
                color: #000;
                font-family: sans-serif;
                font-size: 9px;
                margin: 0;
                padding: 0;
            }
            .page {
                width: 100%;
                max-width: 100%;
                margin: 0;
                padding: 0;
                position: relative;
            }
            .text-xs {
                font-size: 9px;
            }
            .text-sm {
                font-size: 10px;
            }
            .text-base {
                font-size: 11px;
            }
            .text-lg {
                font-size: 13px;
            }
            .text-10 {
                font-size: 8px;
            }
            .text-9 {
                font-size: 7.5px;
            }
            .bold {
                font-weight: bold;
            }
            .italic {
                font-style: italic;
            }
            .uppercase {
                text-transform: uppercase;
            }
            .underline {
                text-decoration: underline;
            }
            .text-center {
                text-align: center;
            }
            .text-left {
                text-align: left;
            }
            .text-right {
                text-align: right;
            }
            .text-justify {
                text-align: justify;
            }
            .text-red {
                color: #c00;
            }
            .text-navy {
                color: #000080;
            }
            .text-gray {
                color: #666;
            }
            .bg-gray {
                background-color: #f5f5f5;
            }
            .border {
                border: 1px solid #000;
            }
            .border-2 {
                border: 2px solid #000;
            }
            .border-b {
                border-bottom: 1px solid #000;
            }
            .border-dashed {
                border-style: dashed;
            }
            .border-t-2 {
                border-top: 2px dashed #000;
            }
            .inline {
                display: inline-block;
            }
            .block {
                display: block;
            }
            .w-full {
                width: 100%;
            }
            .mt-1 {
                margin-top: 3px;
            }
            .mt-2 {
                margin-top: 5px;
            }
            .mt-3 {
                margin-top: 8px;
            }
            .mb-1 {
                margin-bottom: 3px;
            }
            .mb-2 {
                margin-bottom: 5px;
            }
            .mb-3 {
                margin-bottom: 8px;
            }
            .mb-4 {
                margin-bottom: 10px;
            }
            .ml-2 {
                margin-left: 5px;
            }
            .mr-2 {
                margin-right: 5px;
            }
            .mr-4 {
                margin-right: 10px;
            }
            .mr-16 {
                margin-right: 40px;
            }
            .pl-2 {
                padding-left: 5px;
            }
            .pr-2 {
                padding-right: 5px;
            }
            .pr-4 {
                padding-right: 10px;
            }
            .px-1 {
                padding-left: 3px;
                padding-right: 3px;
            }
            .px-2 {
                padding-left: 5px;
                padding-right: 5px;
            }
            .py-1 {
                padding-top: 3px;
                padding-bottom: 3px;
            }
            .py-2 {
                padding-top: 5px;
                padding-bottom: 5px;
            }
            .p-1 {
                padding: 3px;
            }
            .p-2 {
                padding: 5px;
            }
            .p-4 {
                padding: 10px;
            }
            .pt-8 {
                padding-top: 20px;
            }
            .pb-1 {
                padding-bottom: 3px;
            }
            .leading-tight {
                line-height: 1.15;
            }
            .leading-snug {
                line-height: 1.2;
            }
            table {
                border-collapse: collapse;
                width: 100%;
            }
            .checkbox {
                display: inline-block;
                width: 10px;
                height: 10px;
                border: 1.5px solid #000;
                background: #fff;
                vertical-align: middle;
            }
            .cue-box {
                border: 2px solid #000;
            }
            .h-8 {
                height: 18px;
            }
            .h-6 {
                height: 18px;
            }
            .w-8 {
                width: 24px;
            }
            .w-6 {
                width: 18px;
            }
        </style>
    </head>
    <body style="padding: 0">
        <div class="page">
            <table
                style="position: absolute; right: 32px; top: 0; width: auto"
                class="text-navy bold text-sm"
            >
                <tr>
                    <td style="padding: 0 16px 2px 0; text-align: left">HS</td>
                    <td style="text-align: center">-</td>
                </tr>
                <tr>
                    <td style="padding: 0 16px 2px 0; text-align: left">LM</td>
                    <td style="text-align: center">-</td>
                </tr>
                <tr>
                    <td style="padding: 0 16px 2px 0; text-align: left">CCF</td>
                    <td style="text-align: center">-</td>
                </tr>
                <tr>
                    <td style="padding: 0 16px 2px 0; text-align: left">OW</td>
                    <td style="text-align: center">-</td>
                </tr>
                <tr>
                    <td style="padding: 0 16px 2px 0; text-align: left">A</td>
                    <td style="text-align: center">-</td>
                </tr>
                <tr>
                    <td style="padding: 0 16px 2px 0; text-align: left">MED</td>
                    <td style="text-align: center">-</td>
                </tr>
            </table>
            <div style="text-align: center; padding-top: 16px">
                <table style="width: auto; margin: 0 auto">
                    <tr>
                        <td style="padding-right: 24px">
                            <img
                                src="{{ public_path('images/red-cross.png') }}"
                                alt="Philippine Red Cross"
                                style="
                                    width: 40px;
                                    height: 40px;
                                    border-radius: 50%;
                                    background: #eee;
                                "
                            />
                        </td>
                        <td style="padding-left: 24px">
                            <img
                                src="{{ public_path('images/DOH.png') }}"
                                alt="Department of Health"
                                style="
                                    width: 40px;
                                    height: 40px;
                                    border-radius: 50%;
                                    background: #f0fdf0;
                                "
                            />
                        </td>
                    </tr>
                </table>
                <div
                    class="bold underline text-sm"
                    style="letter-spacing: 1px; margin-top: 5px"
                >
                    BLOOD DONOR INTERVIEW SHEET
                </div>
            </div>
        </div>

        <p class="bold" style="margin-top: 4px; padding: 0 8px">
            <b>I. Pernsonal Data</b>(to be filled up by the donor).
        </p>

        <div class="page" style="padding: 8px">
            {{-- NAME --}}
            <table class="mb-2">
                <tr>
                    <td style="width: 190px" class="bold text-sm uppercase">
                        NAME:
                    </td>
                    <td>
                        <table class="border">
                            <tr>
                                <td
                                    class="border border-r"
                                    style="height: 18px; text-align: center"
                                >
                                    {{ $data['surname'] ?? '' }}
                                </td>
                                <td
                                    class="border border-r"
                                    style="height: 18px; text-align: center"
                                >
                                    {{ $data['first_name'] ?? '' }}
                                </td>
                                <td style="height: 18px; text-align: center">
                                    {{ $data['middle_name'] ?? '' }}
                                </td>
                            </tr>
                        </table>
                        <table class="text-xs" style="margin-top: 4px">
                            <tr>
                                <td
                                    class="text-center italic"
                                    style="width: 33%"
                                >
                                    Surname
                                </td>
                                <td
                                    class="text-center italic"
                                    style="width: 33%"
                                >
                                    First Name
                                </td>
                                <td
                                    class="text-center italic"
                                    style="width: 34%"
                                >
                                    Middle Name
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>

            {{-- Birthdate / Age / Civil Status / Sex --}}
            <table class="mb-2">
                <tr>
                    <td style="width: 190px"></td>
                    <td>
                        <table class="border">
                            <tr>
                                <td
                                    class="border border-r"
                                    style="
                                        width: 33%;
                                        height: 18px;
                                        text-align: center;
                                    "
                                >
                                    {{ $data['birthdate'] ?? '' }}
                                </td>
                                <td
                                    class="border border-r"
                                    style="
                                        width: 17%;
                                        height: 18px;
                                        text-align: center;
                                    "
                                >
                                    {{ $data['age'] ?? '' }}
                                </td>
                                <td
                                    class="border border-r"
                                    style="
                                        width: 33%;
                                        height: 18px;
                                        text-align: center;
                                    "
                                >
                                    {{ $data['civil_status'] ?? '' }}
                                </td>
                                <td
                                    style="
                                        width: 17%;
                                        height: 18px;
                                        text-align: center;
                                    "
                                >
                                    {{ $data['sex'] ?? '' }}
                                </td>
                            </tr>
                        </table>
                        <table class="text-10" style="margin-top: 4px">
                            <tr>
                                <td
                                    class="text-center uppercase"
                                    style="width: 33%"
                                >
                                    Birthdate
                                </td>
                                <td
                                    class="text-center uppercase"
                                    style="width: 17%"
                                >
                                    Age
                                </td>
                                <td
                                    class="text-center uppercase"
                                    style="width: 33%"
                                >
                                    Civil Status
                                </td>
                                <td
                                    class="text-center uppercase"
                                    style="width: 17%"
                                >
                                    Sex
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>

            {{-- PERMANENT ADDRESS --}}
            <table class="mb-2">
                <tr>
                    <td style="width: 190px" class="bold text-sm uppercase">
                        PERMANENT ADDRESS:
                    </td>
                    <td>
                        <table class="border">
                            <tr>
                                    <td
                                        class="border border-r"
                                        style="
                                            width: 8%;
                                            height: 18px;
                                            text-align: center;
                                        "
                                    >{{ $data['address_house_no'] ?? '' }}</td>
                                <td
                                    class="border border-r"
                                    style="
                                        width: 25%;
                                        height: 18px;
                                        text-align: center;
                                    "
                                >
                                    {{ $data['address_street'] ?? '' }}
                                </td>
                                <td
                                    class="border border-r"
                                    style="
                                        width: 17%;
                                        height: 18px;
                                        text-align: center;
                                    "
                                >
                                    {{ $data['address_barangay'] ?? '' }}
                                </td>
                                <td
                                    class="border border-r"
                                    style="
                                        width: 17%;
                                        height: 18px;
                                        text-align: center;
                                    "
                                >
                                    {{ $data['address_town'] ?? '' }}
                                </td>
                                <td
                                    class="border border-r"
                                    style="
                                        width: 17%;
                                        height: 18px;
                                        text-align: center;
                                    "
                                >
                                    {{ $data['address_province'] ?? '' }}
                                </td>
                                <td
                                    style="
                                        width: 16%;
                                        height: 18px;
                                        text-align: center;
                                    "
                                >
                                    {{ $data['address_zip'] ?? '' }}
                                </td>
                            </tr>
                        </table>
                        <table class="text-10" style="margin-top: 4px">
                            <tr>
                                <td style="width: 8%">No.</td>
                                <td style="width: 25%">Street</td>
                                <td style="width: 17%">Barangay</td>
                                <td style="width: 17%">Town/Municipality</td>
                                <td style="width: 17%">Province/City</td>
                                <td style="width: 16%">Zip Code</td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>

            {{-- OFFICE ADDRESS --}}
            <table class="mb-2">
                <tr>
                    <td style="width: 190px" class="bold text-sm uppercase">
                        OFFICE ADDRESS
                    </td>
                    <td>
                        <div
                            class="border"
                            style="
                                height: 18px;
                                text-align: center;
                                line-height: 18px;
                            "
                        ></div>
                    </td>
                </tr>
            </table>

            {{-- Nationality / Religion / Education / Occupation --}}
            <table class="mb-2">
                <tr>
                    <td style="width: 190px"></td>
                    <td>
                        <table class="border">
                            <tr>
                                <td
                                    class="border border-r"
                                    style="
                                        width: 25%;
                                        height: 18px;
                                        text-align: center;
                                    "
                                >
                                    {{ $data['nationality'] ?? '' }}
                                </td>
                                <td
                                    class="border border-r"
                                    style="
                                        width: 25%;
                                        height: 18px;
                                        text-align: center;
                                    "
                                >
                                    {{ $data['religion'] ?? '' }}
                                </td>
                                <td
                                    class="border border-r"
                                    style="
                                        width: 25%;
                                        height: 18px;
                                        text-align: center;
                                    "
                                >
                                    {{ $data['education'] ?? '' }}
                                </td>
                                <td
                                    style="
                                        width: 25%;
                                        height: 18px;
                                        text-align: center;
                                    "
                                >
                                    {{ $data['occupation'] ?? '' }}
                                </td>
                            </tr>
                        </table>
                        <table class="text-10" style="margin-top: 4px">
                            <tr>
                                <td
                                    class="text-center uppercase"
                                    style="width: 25%"
                                >
                                    Nationality
                                </td>
                                <td
                                    class="text-center uppercase"
                                    style="width: 25%"
                                >
                                    Religion
                                </td>
                                <td
                                    class="text-center uppercase"
                                    style="width: 25%"
                                >
                                    Education
                                </td>
                                <td
                                    class="text-center uppercase"
                                    style="width: 25%"
                                >
                                    Occupation
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>

            {{-- CONTACT No. --}}
            <table class="mb-2">
                <tr>
                    <td style="width: 190px" class="bold text-sm uppercase">
                        CONTACT No.:
                    </td>
                    <td>
                        <table class="border">
                            <tr>
                                <td
                                    class="border border-r"
                                    style="
                                        width: 33%;
                                        height: 18px;
                                        text-align: center;
                                    "
                                >
                                    {{ $data['telephone_no'] ?? '' }}
                                </td>
                                <td
                                    class="border border-r"
                                    style="
                                        width: 33%;
                                        height: 18px;
                                        text-align: center;
                                    "
                                >
                                    {{ $data['mobile_no'] ?? '' }}
                                </td>
                                <td
                                    style="
                                        width: 34%;
                                        height: 18px;
                                        text-align: center;
                                    "
                                >
                                    {{ $data['email'] ?? '' }}
                                </td>
                            </tr>
                        </table>
                        <table class="text-10" style="margin-top: 4px">
                            <tr>
                                <td
                                    class="text-center uppercase"
                                    style="width: 33%"
                                >
                                    Telephone No.
                                </td>
                                <td
                                    class="text-center uppercase"
                                    style="width: 33%"
                                >
                                    Mobile No.
                                </td>
                                <td
                                    class="text-center uppercase"
                                    style="width: 34%"
                                >
                                    E-Mail Address
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>

            {{-- IDENTIFICATION No. --}}
            <table class="mb-2">
                <tr>
                    <td style="width: 190px" class="bold text-sm uppercase">
                        IDENTIFICATION No.:
                    </td>
                    <td>
                        <table class="border">
                            <tr>
                                <td
                                    class="border border-r"
                                    style="width: 16%; height: 24px"
                                ></td>
                                <td
                                    class="border border-r"
                                    style="width: 16%; height: 24px"
                                ></td>
                                <td
                                    class="border border-r"
                                    style="width: 16%; height: 24px"
                                ></td>
                                <td
                                    class="border border-r"
                                    style="width: 16%; height: 24px"
                                ></td>
                                <td
                                    class="border border-r"
                                    style="width: 16%; height: 24px"
                                ></td>
                                <td style="width: 20%; height: 24px"></td>
                            </tr>
                        </table>
                        <table class="text-10" style="margin-top: 4px">
                            <tr>
                                <td style="width: 16%">School</td>
                                <td style="width: 16%">Company</td>
                                <td style="width: 16%">PRC</td>
                                <td style="width: 16%">Driver's</td>
                                <td style="width: 16%">SSS/GSIS/BIR</td>
                                <td style="width: 20%">Others</td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
        </div>

        <p class="bold" style="padding: 0 8px">
            <b>II. Medical History</b>(Please read carefully and answer all
            relevant questions. Tick (&#10003;) the appropriate answer).
        </p>

        <div class="page" style="padding: 8px">
            <table
                class="w-full border"
                style="font-size: 9px; line-height: 1.15"
            >
                <thead>
                    <tr>
                        <th
                            class="border"
                            style="width: 24px; padding: 2px"
                        ></th>
                        <th
                            class="border"
                            style="padding: 2px; text-align: left"
                        ></th>
                        <th
                            class="border"
                            style="width: 40px; padding: 2px"
                            class="bold text-center"
                        >
                            YES
                        </th>
                        <th
                            class="border"
                            style="width: 40px; padding: 2px"
                            class="bold text-center"
                        >
                            NO
                        </th>
                        <th
                            class="border"
                            style="width: 95px; padding: 2px"
                            class="bold text-center"
                        >
                            REMARKS
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach([
                                [1, 'Do you feel well and healthy today?'],
                                [
                                    2,
                                    'Have you ever been refused as a blood donor or told not to
                                                donate blood for any reasons?'
                                ],
                                [
                                    3,
                                    'Are you giving blood
                                                only because you want to be tested for HIV or the AIDS virus
                                                or Hepatitis virus?'
                                ],
                                [
                                    4,
                                    'Are you aware that an HIV /
                                                Hepatitis infected person can still transmit the virus
                                                despite a negative HIV / Hepatitis test?'
                                ],
                                [
                                    5,
                                    'Have you
                                                within the last
                                                <b>12 HOURS</b>
                                                had taken liquor, beer or any drinks with alcohol?'
                                ],
                                [
                                    6,
                                    'In the last
                                                <b>3 DAYS</b>
                                                have you taken aspirin?'
                                ],
                                [
                                    7,
                                    'In the past
                                                <b>4 WEEKS</b>
                                                have you taken any medications and/or vaccinations?'
                                ],
                                [
                                    8,
                                    'In the past
                                                <b>3 MONTHS</b>
                                                have you donated whole blood, platelets or plasma?'
                                ],
                        ] as [$num, $q])
                        <tr>
                            <td
                                class="border px-1"
                                style="text-align: center; vertical-align: top"
                            >
                                {{ $num }}.
                            </td>
                            <td class="border px-1">{!! $q !!}</td>
                            <td class="border px-1"></td>
                            <td class="border px-1"></td>
                            <td class="border px-1"></td>
                        </tr>
                    @endforeach

                    <tr class="bg-gray">
                        <td class="border"></td>
                        <td
                            class="bold text-9 border uppercase"
                            style="padding: 2px"
                        >
                            IN THE PAST 6 MONTHS HAVE YOU:
                        </td>
                        <td class="border"></td>
                        <td class="border"></td>
                        <td class="border"></td>
                    </tr>

                    @foreach([
                            [
                                9,
                                'Been to any places in the Philippines or
                                            countries infected with ZIKA Virus?'
                            ],
                            [
                                10,
                                'Had sexual
                                            contact with a person who was confirmed to have ZIKA Virus
                                            infection?'
                            ],
                            [
                                11,
                                'Had sexual contact with a person who has
                                            been to any places in the Philippines or countries infected
                                            with ZIKA Virus?'
                            ],
                        ] as [$num, $q])
                        <tr>
                            <td
                                class="border px-1"
                                style="text-align: center; vertical-align: top"
                            >
                                {{ $num }}.
                            </td>
                            <td class="border px-1">{{ $q }}</td>
                            <td class="border px-1"></td>
                            <td class="border px-1"></td>
                            <td class="border px-1"></td>
                        </tr>
                    @endforeach

                    <tr class="bg-gray">
                        <td class="border"></td>
                        <td
                            class="bold text-9 border uppercase"
                            style="padding: 2px"
                        >
                            IN THE PAST 12 MONTHS HAVE YOU:
                        </td>
                        <td class="border"></td>
                        <td class="border"></td>
                        <td class="border"></td>
                    </tr>

                    @foreach([
                                [
                                    12,
                                    'Received blood, blood products and/or had
                                                tissue/organ transplant or graft?'
                                ],
                                [
                                    13,
                                    'Had surgical
                                                operation or dental extraction?'
                                ],
                                [
                                    14,
                                    'Had a tattoo
                                                applied, ear and body piercing, acupuncture, needle stick
                                                injury or accidental contact with blood?'
                                ],
                                [
                                    15,
                                    'Had sexual
                                                contact with high risks individuals or in exchange for
                                                material or monetary gain?'
                                ],
                                [
                                    16,
                                    'Engaged in unprotected,
                                                unsafe or casual sex?'
                                ],
                                [
                                    17,
                                    'Had jaundice/hepatitis/
                                                personal contact with person who had hepatitis?'
                                ],
                                [
                                    18,
                                    'Been incarcerated, jailed or imprisoned?'
                                ],
                                [
                                    19,
                                    'Spent
                                                time or have relatives in the United Kingdom or Europe?'
                                ],
                        ] as [$num, $q])
                        <tr>
                            <td
                                class="border px-1"
                                style="text-align: center; vertical-align: top"
                            >
                                {{ $num }}.
                            </td>
                            <td class="border px-1">{{ $q }}</td>
                            <td class="border px-1"></td>
                            <td class="border px-1"></td>
                            <td class="border px-1"></td>
                        </tr>
                    @endforeach

                    <tr class="bg-gray">
                        <td class="border"></td>
                        <td
                            class="bold text-9 border uppercase"
                            style="padding: 2px"
                        >
                            HAVE YOU EVER:
                        </td>
                        <td class="border"></td>
                        <td class="border"></td>
                        <td class="border"></td>
                    </tr>

                    @foreach([
                                [
                                    20,
                                    'Travelled or lived outside of your place of
                                                residence or outside the Philippines?'
                                ],
                                [
                                    21,
                                    'Taken
                                                prohibited drugs (orally, by nose, or by injection)?'
                                ],
                                [
                                    22,
                                    'Used clotting factor concentrates?'
                                ],
                                [
                                    23,
                                    'Had a positive
                                                test for the HIV virus, Hepatitis virus, Syphilis or
                                                Malaria?'
                                ],
                                [24, 'Had Malaria or Hepatitis in the past?'],
                                [
                                    25,
                                    'Had or was treated for genital wart, syphilis,
                                                gonorrhea or other sexually transmitted diseases?'
                                ],
                        ] as [$num, $q])
                        <tr>
                            <td
                                class="border px-1"
                                style="text-align: center; vertical-align: top"
                            >
                                {{ $num }}.
                            </td>
                            <td class="border px-1">{{ $q }}</td>
                            <td class="border px-1"></td>
                            <td class="border px-1"></td>
                            <td class="border px-1"></td>
                        </tr>
                    @endforeach

                    <tr class="bg-gray">
                        <td class="border"></td>
                        <td
                            class="bold text-9 border uppercase"
                            style="padding: 2px"
                        >
                            HAD ANY OF THE FOLLOWING:
                        </td>
                        <td class="border"></td>
                        <td class="border"></td>
                        <td class="border"></td>
                    </tr>

                    @foreach([
                            [
                                26,
                                'Cancer, blood disease or bleeding disorder
                                            (hemophilia)?'
                            ],
                            [
                                27,
                                'Heart disease/surgery, rheumatic
                                            fever or chest pains?'
                            ],
                            [
                                28,
                                'Lung disease, tuberculosis or
                                            asthma?'
                            ],
                            [
                                29,
                                'Kidney disease, thyroid disease, diabetes,
                                            epilepsy?'
                            ],
                            [30, 'Chicken pox and/or cold sores?'],
                            [
                                31,
                                'Any other chronic medical condition or surgical
                                            operations?'
                            ],
                            [
                                32,
                                'Have you recently had rash and/or
                                            fever? Was/ were this/these also associated with arthralgia
                                            or arthritis or conjunctivitis?'
                            ],
                        ] as [$num, $q])
                        <tr>
                            <td
                                class="border px-1"
                                style="text-align: center; vertical-align: top"
                            >
                                {{ $num }}.
                            </td>
                            <td class="border px-1">{{ $q }}</td>
                            <td class="border px-1"></td>
                            <td class="border px-1"></td>
                            <td class="border px-1"></td>
                        </tr>
                    @endforeach

                    <tr class="bg-gray">
                        <td class="border"></td>
                        <td
                            class="bold text-9 border text-center uppercase"
                            style="padding: 2px"
                        >
                            FOR FEMALE DONORS ONLY:
                        </td>
                        <td class="border"></td>
                        <td class="border"></td>
                        <td class="border"></td>
                    </tr>

                    @foreach([
                            [
                                33,
                                'Are you currently pregnant or have you ever
                                            been pregnant?'
                            ],
                            [34, 'When was your last childbirth?'],
                            [
                                35,
                                'In the past
                                            <b>1 YEAR</b
                                            >, did you have a miscarriage or abortion?'
                            ],
                            [
                                36,
                                'Are you
                                            currently breastfeeding?'
                            ],
                            [
                                37,
                                'When was your last
                                            menstrual period?'
                            ],
                        ] as [$num, $q])
                        <tr>
                            <td
                                class="border px-1"
                                style="text-align: center; vertical-align: top"
                            >
                                {{ $num }}.
                            </td>
                            <td class="border px-1">{!! $q !!}</td>
                            <td class="border px-1"></td>
                            <td class="border px-1"></td>
                            <td class="border px-1"></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        {{-- DONOR'S DECLARATION --}}
        <div class="page" style="padding: 0 0 0 8px">
            <div class="bold mb-2" style="font-size: 11px">
                III. DONOR&#8217;S DECLARATION
            </div>

            <table style="font-size: 9px">
                <tr>
                    <td style="padding: 0 0 4px 0">
                        <table>
                            <tr>
                                <td style="width: 16px; padding-right: 8px">
                                    &#9658;
                                </td>
                                <td style="text-align: justify">
                                    I certify that I am the person referred to
                                    above and that all the entries are read and
                                    well understood by me and to the best of my
                                    knowledge, truthfully answered all the
                                    questions in this Blood Donor Interview
                                    Sheet.
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td style="padding: 0 0 4px 0">
                        <table>
                            <tr>
                                <td style="width: 16px; padding-right: 8px">
                                    &#9658;
                                </td>
                                <td style="text-align: justify">
                                    I understand that all questions are
                                    pertinent for my safety and for the benefit
                                    of the patient who will undergo blood
                                    transfusion.
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td style="padding: 0 0 4px 0">
                        <table>
                            <tr>
                                <td style="width: 16px; padding-right: 8px">
                                    &#9658;
                                </td>
                                <td style="text-align: justify">
                                    I am voluntarily giving my blood through the
                                    Philippine Red Cross, without remuneration,
                                    for the use of persons in need of this vital
                                    fluid without regard to rank, race, color,
                                    creed, religion, or political persuasion.
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td style="padding: 0 0 4px 0">
                        <table>
                            <tr>
                                <td style="width: 16px; padding-right: 8px">
                                    &#9658;
                                </td>
                                <td style="text-align: justify">
                                    I understand that my blood will be screened
                                    for Malaria, Syphilis, Hepatitis B,
                                    Hepatitis C and HIV. I am aware that the
                                    screening tests are not diagnostic and may
                                    yield false positive results. Should any of
                                    the screening tests give a reactive result,
                                    I authorize the Red Cross to inform me
                                    utilizing the information I have supplied,
                                    subject the results to confirmatory tests,
                                    offer counselling and to dispose of my
                                    donated blood in any way it may deem
                                    advisable for the safety of the majority of
                                    the populace.
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td style="padding: 0 0 4px 0">
                        <table>
                            <tr>
                                <td style="width: 16px; padding-right: 8px">
                                    &#9658;
                                </td>
                                <td style="text-align: justify">
                                    I confirm that I am over the age of 18
                                    years.
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td style="padding: 0 0 4px 0">
                        <table>
                            <tr>
                                <td style="width: 16px; padding-right: 8px">
                                    &#9658;
                                </td>
                                <td style="text-align: justify">
                                    I understand that all information hereinto
                                    is treated confidential in compliance with
                                    the Data Privacy Act of 2012. I therefore
                                    authorize the Philippine Red Cross to
                                    utilize the information I supplied for
                                    purposes of research or studies for the
                                    benefit and safety of the community.
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>

            <table class="mb-4" style="margin-top: 16px">
                <tr>
                    <td style="width: 50%; vertical-align: top">
                        <table class="border" style="height: 80px">
                            <tr>
                                <td
                                    class="bold border-b text-center"
                                    style="font-size: 10px; padding: 4px"
                                >
                                    For those ages 16-17
                                </td>
                            </tr>
                            <tr>
                                <td
                                    style="
                                        vertical-align: bottom;
                                        padding: 32px 4px 4px 4px;
                                    "
                                >
                                    <table>
                                        <tr>
                                            <td
                                                class="border-r"
                                                style="width: 50%"
                                            >
                                                <div
                                                    class="mb-1 border-b"
                                                ></div>
                                                <span class="text-9"
                                                    >Signature of Parent or
                                                    Guardian</span
                                                >
                                            </td>
                                            <td
                                                style="
                                                    width: 50%;
                                                    padding-left: 4px;
                                                "
                                            >
                                                <div
                                                    class="mb-1 border-b"
                                                ></div>
                                                <span class="text-9"
                                                    >Relationship to Blood
                                                    Donor</span
                                                >
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                        </table>
                    </td>
                    <td
                        style="
                            width: 50%;
                            padding-left: 32px;
                            vertical-align: bottom;
                        "
                    >
                        <table style="width: 100%">
                            <tr>
                                <td
                                    style="
                                        width: 50%;
                                        text-align: center;
                                        vertical-align: bottom;
                                    "
                                >
                                    <div class="mb-1 border-b"></div>
                                    <span class="text-10"
                                        >Donor's Signature</span
                                    >
                                </td>
                                <td
                                    style="
                                        width: 50%;
                                        text-align: center;
                                        vertical-align: bottom;
                                    "
                                >
                                    <div class="mb-1 border-b"></div>
                                    <span class="text-10"
                                        >Donor's Thumbmark</span
                                    >
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>

            <div class="bold mb-2" style="font-size: 13px">
                IV. INITIAL SCREENING (To be filled up by the interviewer)
            </div>

            <table class="text-10 mb-2 w-full border text-center">
                <thead>
                    <tr>
                        <th colspan="4" class="border"></th>
                        <th
                            colspan="3"
                            class="bold border text-xs"
                            style="background: #f0f0f0"
                        >
                            FOR APHERESIS DONOR
                        </th>
                        <th class="border"></th>
                    </tr>
                    <tr>
                        <th class="border px-1 py-1" style="width: 12%">
                            BODY WT
                        </th>
                        <th class="border px-1 py-1" style="width: 12%">
                            SP. GR
                        </th>
                        <th class="border px-1 py-1" style="width: 12%">HGB</th>
                        <th class="border px-1 py-1" style="width: 12%">HCT</th>
                        <th class="border px-1 py-1" style="width: 12%">RBC</th>
                        <th class="border px-1 py-1" style="width: 12%">WBC</th>
                        <th class="border px-1 py-1" style="width: 12%">
                            PLT count
                        </th>
                        <th
                            class="border px-1 py-1"
                            style="width: 16%; background: #f0f0f0"
                            class="bold"
                        >
                            BLOOD TYPE
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <tr style="height: 32px">
                        <td class="border"></td>
                        <td class="border"></td>
                        <td class="border"></td>
                        <td class="border"></td>
                        <td class="border"></td>
                        <td class="border"></td>
                        <td class="border"></td>
                        <td class="border"></td>
                    </tr>
                </tbody>
            </table>

            <table class="text-10 mb-4" style="font-size: 10px">
                <tr>
                    <td style="width: 50%; vertical-align: top">
                        <table>
                            <tr>
                                <td class="bold" style="width: 130px">
                                    TYPE OF DONATION:
                                </td>
                                <td class="bold" style="width: 160px">
                                    IN-HOUSE:
                                </td>
                                <td style="text-align: right">( )</td>
                            </tr>
                            <tr>
                                <td></td>
                                <td class="bold">WALK- IN/VOLUNTARY:</td>
                                <td style="text-align: right">( )</td>
                            </tr>
                            <tr>
                                <td></td>
                                <td class="bold">REPLACEMENT:</td>
                                <td style="text-align: right">( )</td>
                            </tr>
                            <tr>
                                <td></td>
                                <td class="bold">PATIENT-DIRECTED:</td>
                                <td style="text-align: right">( )</td>
                            </tr>
                        </table>
                    </td>
                    <td
                        style="
                            width: 50%;
                            padding-left: 16px;
                            vertical-align: top;
                        "
                    >
                        <table>
                            <tr>
                                <td class="bold" style="white-space: nowrap">
                                    Mobile Blood Donation
                                </td>
                                <td style="text-align: right">( )</td>
                            </tr>
                            <tr>
                                <td
                                    class="bold"
                                    style="
                                        text-align: right;
                                        padding-right: 4px;
                                        white-space: nowrap;
                                    "
                                >
                                    PLACE:
                                </td>
                                <td class="border-b"></td>
                            </tr>
                            <tr>
                                <td
                                    class="bold"
                                    style="
                                        text-align: right;
                                        padding-right: 4px;
                                        white-space: nowrap;
                                    "
                                >
                                    ORGANIZER:
                                </td>
                                <td class="border-b"></td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>

            <table
                class="text-10 mb-4 border text-center"
                style="font-size: 10px"
            >
                <tr>
                    <td class="border-r" style="width: 42%; height: 32px"></td>
                    <td class="border-r" style="width: 25%; height: 32px"></td>
                    <td class="border-r" style="width: 8%; height: 32px"></td>
                    <td class="border-r" style="width: 17%; height: 32px"></td>
                    <td style="width: 8%; height: 32px"></td>
                </tr>
                <tr>
                    <td class="bold border-t py-1" style="width: 42%">
                        Patient Name
                    </td>
                    <td class="bold border-t py-1" style="width: 25%">
                        Hospital
                    </td>
                    <td class="bold border-t py-1" style="width: 8%">
                        Blood Type
                    </td>
                    <td class="bold border-t py-1" style="width: 17%">
                        WB/Component
                    </td>
                    <td class="bold border-t py-1" style="width: 8%">
                        No. of units
                    </td>
                </tr>
            </table>

            <table class="text-11 bold mb-2" style="font-size: 12px">
                <tr>
                    <td style="padding-right: 24px">
                        History of previous donation?
                    </td>
                    <td style="padding-right: 24px">( ) YES</td>
                    <td>( ) NO</td>
                </tr>
            </table>

            <table class="text-10 mb-4 w-full border" style="font-size: 10px">
                <thead>
                    <tr>
                        <th class="border p-1" style="width: 33%"></th>
                        <th class="border p-1" style="width: 33%">Red Cross</th>
                        <th class="border p-1" style="width: 34%">Hospital</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="border px-1 py-1">No. of times</td>
                        <td class="border"></td>
                        <td class="border"></td>
                    </tr>
                    <tr>
                        <td class="border px-1 py-1">Date of last donation</td>
                        <td class="border"></td>
                        <td class="border"></td>
                    </tr>
                    <tr>
                        <td class="border px-1 py-1">Place of last donation</td>
                        <td class="border"></td>
                        <td class="border"></td>
                    </tr>
                </tbody>
            </table>

            <table class="text-10 mb-4" style="font-size: 10px">
                <tr>
                    <td
                        style="
                            width: 33%;
                            text-align: center;
                            vertical-align: bottom;
                        "
                    >
                        <div class="mb-1 border-b"></div>
                        <div class="bold italic">
                            INTERVIEWER (print name & sign)
                        </div>
                    </td>
                    <td
                        style="
                            width: 33%;
                            text-align: center;
                            padding: 0 16px;
                            vertical-align: bottom;
                        "
                    >
                        <div class="mb-1 border-b"></div>
                        <div>PRC Office</div>
                    </td>
                    <td
                        style="
                            width: 34%;
                            text-align: center;
                            vertical-align: bottom;
                        "
                    >
                        <div class="mb-1 border-b"></div>
                        <div>Date</div>
                    </td>
                </tr>
            </table>

            <div
                class="bold border-2t mb-1 pt-2"
                style="font-size: 13px; padding-top: 8px"
            >
                V. PHYSICAL EXAMINATION (To be accomplished by the Blood Bank
                Physician)
            </div>

            <table
                class="text-10 mb-4 w-full border text-center"
                style="font-size: 10px"
            >
                <thead>
                    <tr>
                        <th class="border px-1 py-1" style="width: 14%">Blood Pressure</th>
                        <th class="border px-1 py-1" style="width: 14%">Pulse Rate</th>
                        <th class="border px-1 py-1" style="width: 14%">Body Temp.</th>
                        <th class="border px-1 py-1" style="width: 14%">Gen. Appearance</th>
                        <th class="border px-1 py-1" style="width: 14%">Skin</th>
                        <th class="border px-1 py-1" style="width: 14%">HEENT</th>
                        <th class="border px-1 py-1" style="width: 16%">Heart and Lungs</th>
                    </tr>
                </thead>
                <tbody>
                    <tr style="height: 32px">
                        <td class="border"></td>
                        <td class="border"></td>
                        <td class="border"></td>
                        <td class="border"></td>
                        <td class="border"></td>
                        <td class="border"></td>
                        <td class="border"></td>
                    </tr>
                </tbody>
            </table>

            <table class="text-10 mb-4" style="font-size: 10px">
                <tr>
                    <td style="width: 50%; vertical-align: top">
                        <div class="bold mb-1">REMARKS:</div>
                        <table>
                            <tr>
                                <td class="bold" style="width: 24px">( )</td>
                                <td>Accepted</td>
                                <td colspan="2"></td>
                            </tr>
                            <tr>
                                <td class="bold">( )</td>
                                <td style="width: 130px">
                                    Temporarily Deferred
                                </td>
                                <td colspan="2" style="white-space: nowrap">Reason: <span style="border-bottom: 1px solid #000; display: inline-block; min-width: 180px">&nbsp;</span></td>
                            </tr>
                            <tr>
                                <td class="bold">( )</td>
                                <td style="width: 130px">
                                    Permanently Deferred
                                </td>
                                <td colspan="2" style="white-space: nowrap">Reason: <span style="border-bottom: 1px solid #000; display: inline-block; min-width: 180px">&nbsp;</span></td>
                            </tr>
                            <tr>
                                <td class="bold">( )</td>
                                <td style="width: 130px">Refused</td>
                                <td colspan="2" style="white-space: nowrap">Reason: <span style="border-bottom: 1px solid #000; display: inline-block; min-width: 180px">&nbsp;</span></td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>

            <table class="text-10 mb-6" style="font-size: 10px">
                <tr>
                    <td style="vertical-align: top">
                        <table>
                            <tr>
                                <td class="bold" style="white-space: nowrap">
                                    Blood bag to be used: (mark [V] appropriate
                                    box):
                                </td>
                                <td>
                                    <span
                                        class="checkbox"
                                        style="width: 12px; height: 12px"
                                    ></span>
                                </td>
                                <td>Single</td>
                                <td style="padding-left: 8px">
                                    <span
                                        class="checkbox"
                                        style="width: 12px; height: 12px"
                                    ></span>
                                </td>
                                <td>Double</td>
                                <td style="padding-left: 8px">
                                    <span
                                        class="checkbox"
                                        style="width: 12px; height: 12px"
                                    ></span>
                                </td>
                                <td>Triple</td>
                                <td style="padding-left: 8px">
                                    <span
                                        class="checkbox"
                                        style="width: 12px; height: 12px"
                                    ></span>
                                </td>
                                <td>Quadruple</td>
                                <td style="padding-left: 8px">
                                    <span
                                        class="checkbox"
                                        style="width: 12px; height: 12px"
                                    ></span>
                                </td>
                                <td>Top & Bottom</td>
                                <td style="padding-left: 8px">
                                    <span
                                        class="checkbox"
                                        style="width: 12px; height: 12px"
                                    ></span>
                                </td>
                                <td>Apheresis</td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td style="text-align: right; padding-top: 8px">
                        <div style="display: inline-block; width: 300px; text-align: center">
                            <div class="mb-1 border-b"></div>
                            <div class="bold italic">
                                BSF PHYSICIAN<br />(print name & sign)
                            </div>
                        </div>
                    </td>
                </tr>
            </table>

            <div style="font-weight: bold; margin-bottom: 4px">
                VI. BLOOD COLLECTION (To be accomplished by the phlebotomist)
            </div>

            <div style="font-size: 10px; margin-bottom: 8px; font-weight: bold">
                Blood Bag Used:
            </div>

            <div
                style="
                    border: 1px solid #000;
                    font-size: 10px;
                    margin-bottom: 16px;
                "
            >
                <table
                    style="
                        width: 100%;
                        border-collapse: collapse;
                        text-align: center;
                    "
                >
                    <thead>
                        <tr>
                            <th
                                colspan="4"
                                style="
                                    border-bottom: 1px solid #000;
                                    border-right: 1px solid #000;
                                    padding: 4px 0;
                                "
                            >
                                KARMI
                            </th>
                            <th
                                colspan="2"
                                style="
                                    border-bottom: 1px solid #000;
                                    border-right: 1px solid #000;
                                    padding: 4px 0;
                                "
                            >
                                SPECIAL BAG
                            </th>
                            <th
                                colspan="3"
                                style="
                                    border-bottom: 1px solid #000;
                                    padding: 4px 0;
                                "
                            >
                                APHERESIS
                            </th>
                        </tr>
                        <tr>
                            <th
                                style="
                                    border-right: 1px solid #000;
                                    font-weight: normal;
                                    padding: 4px 0;
                                    width: 11%;
                                "
                            >
                                Single
                            </th>
                            <th
                                style="
                                    border-right: 1px solid #000;
                                    font-weight: normal;
                                    padding: 4px 0;
                                    width: 11%;
                                "
                            >
                                Double
                            </th>
                            <th
                                style="
                                    border-right: 1px solid #000;
                                    font-weight: normal;
                                    padding: 4px 0;
                                    width: 11%;
                                "
                            >
                                Triple
                            </th>
                            <th
                                style="
                                    border-right: 1px solid #000;
                                    font-weight: normal;
                                    padding: 4px 0;
                                    width: 11%;
                                "
                            >
                                Quadruple
                            </th>
                            <th
                                style="
                                    border-right: 1px solid #000;
                                    font-weight: normal;
                                    padding: 4px 0;
                                    width: 11%;
                                "
                            >
                                FK T&B
                            </th>
                            <th
                                style="
                                    border-right: 1px solid #000;
                                    font-weight: normal;
                                    padding: 4px 0;
                                    width: 11%;
                                "
                            >
                                TRM T&B
                            </th>
                            <th
                                style="
                                    border-right: 1px solid #000;
                                    font-weight: normal;
                                    padding: 4px 0;
                                    width: 11%;
                                "
                            >
                                Amicore
                            </th>
                            <th
                                style="
                                    border-right: 1px solid #000;
                                    font-weight: normal;
                                    padding: 4px 0;
                                    width: 11%;
                                "
                            >
                                Haemonetics
                            </th>
                            <th
                                style="
                                    font-weight: normal;
                                    padding: 4px 0;
                                    width: 12%;
                                "
                            >
                                Trima
                            </th>
                        </tr>
                    </thead>
                </table>
            </div>

            <table style="font-size: 10px; margin-bottom: 8px; width: 100%">
                <tr>
                    <td style="width: 50%; vertical-align: top; padding-right: 8px">
                        <table style="width: 100%; margin-bottom: 4px">
                            <tr>
                                <td style="white-space: nowrap; font-weight: bold">Amount of Blood Taken:</td>
                                <td style="border-bottom: 1px solid #000; width: 96px"></td>
                                <td style="font-weight: bold; padding-left: 4px; white-space: nowrap">ml.</td>
                            </tr>
                        </table>
                        <table style="width: 100%; margin-bottom: 4px">
                            <tr>
                                <td style="white-space: nowrap; font-weight: bold">Donor Reaction:</td>
                                <td style="border-bottom: 1px solid #000; width: 100%"></td>
                            </tr>
                        </table>
                        <table style="width: 100%">
                            <tr>
                                <td style="white-space: nowrap; font-weight: bold">Management Done:</td>
                                <td style="border-bottom: 1px solid #000; width: 100%"></td>
                            </tr>
                        </table>
                    </td>
                    <td style="width: 50%; vertical-align: top; padding-left: 8px">
                        <table style="width: 100%; margin-bottom: 4px">
                            <tr>
                                <td style="white-space: nowrap; font-weight: bold">Successful:</td>
                                <td style="white-space: nowrap; font-weight: bold; padding-left: 8px">YES _______</td>
                                <td style="white-space: nowrap; font-weight: bold; padding-left: 8px">NO _______</td>
                            </tr>
                        </table>
                        <table style="width: 100%">
                            <tr>
                                <td style="white-space: nowrap; font-weight: bold">Start Time:</td>
                                <td style="border-bottom: 1px solid #000; width: 80px"></td>
                                <td style="white-space: nowrap; font-weight: bold; padding: 0 4px 0 16px">End Time:</td>
                                <td style="border-bottom: 1px solid #000; width: 80px"></td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>

            <table style="width: 100%; margin-top: 32px">
                <tr>
                    <td style="width: auto; vertical-align: bottom">
                        <div style="border: 2px solid #000; padding: 12px 32px; text-align: center; font-weight: bold; font-size: 12px; display: inline-block">
                            BBIS DONATION ID
                        </div>
                    </td>
                    <td style="width: 256px; vertical-align: bottom; text-align: center">
                        <div style="border-bottom: 1px solid #000; margin-bottom: 4px"></div>
                        <div style="font-weight: bold; font-size: 10px">
                            PHLEBOTOMIST<br />(print name & sign)
                        </div>
                    </td>
                </tr>
            </table>

            <div
                style="
                    text-align: right;
                    font-size: 8px;
                    margin-top: 32px;
                    font-weight: bold;
                "
            >
                PRC-NBS DONOR FORM 321-E Revised Sep2025
            </div>
        </div>

        {{-- CUE Section --}}
        <div class="page" style="padding: 0">
            <div
                style="
                    border-top: 1.5px dashed #000;
                    margin-top: 4px;
                    margin-bottom: 6px;
                    position: relative;
                "
            >
                <span
                    style="
                        position: absolute;
                        top: -12px;
                        left: 0;
                        background: #fff;
                        padding-right: 6px;
                        font-size: 16px;
                    "
                    >&#9998;</span
                >
            </div>

            <div class="border-2 p-2">
                <div class="bold mb-1 text-center text-sm">
                    CONFIDENTIAL UNIT EXCLUSION (CUE)
                </div>

                <p class="mb-2 text-justify text-10 leading-tight">
                    Please <b>MARK</b> one of the boxes below. If at one point
                    <b>DURING</b> or <b>AFTER</b> donating blood is unsure of
                    your initial answer, please inform our Blood Service Staff
                    immediately. If you have already left the blood donation
                    venue, contact the PRC Headquarters at telephone number
                    (02)790-2300 or any Philippine Red Cross Office nearest you.
                    <span class="bold text-xs" style="color: #c00"
                        >(046) 402-6267 / 0926-685-9594</span
                    >
                </p>

                <p class="bold mb-3 text-center text-xs underline">
                    MARK ONE BOX ONLY. YOUR RESPONSE WILL BE STRICTLY
                    CONFIDENTIAL.
                </p>

                <table class="mb-2">
                    <tr>
                        <td
                            class="bold text-right text-10"
                            style="width: 120px; padding-right: 4px"
                        >
                            I BELIEVE THAT MY<br />BLOOD IS:
                        </td>
                        <td style="padding: 0 4px; text-align: center">
                            <div class="text-9 bold">
                                SAFE<br /><span style="font-weight: normal; font-size: 7.5px;"
                                    >for transfusion</span
                                >
                            </div>
                        </td>
                        <td>
                            <div
                                class="checkbox h-8 w-8"
                                style="width: 18px; height: 18px"
                            ></div>
                        </td>
                        <td style="padding: 0 4px; text-align: center">
                            <div class="text-9 bold">
                                NOT SAFE<br /><span style="font-weight: normal; font-size: 7.5px;"
                                    >for transfusion</span
                                >
                            </div>
                        </td>
                        <td>
                            <div
                                class="checkbox h-8 w-8"
                                style="width: 18px; height: 18px"
                            ></div>
                        </td>
                        <td style="padding-left: 12px">
                            <table style="width: 200px">
                                <tr>
                                    <td
                                        colspan="2"
                                        class="bold border-2 py-1 text-center"
                                        style="background: #f5f5f5"
                                    >
                                        BBIS DONATION ID
                                    </td>
                                </tr>
                                <tr>
                                    <td
                                        style="
                                            white-space: nowrap;
                                            padding-right: 8px;
                                        "
                                    >
                                        DATE OF DONATION:
                                    </td>
                                    <td class="border-b"></td>
                                </tr>
                                <tr>
                                    <td
                                        style="
                                            white-space: nowrap;
                                            padding-right: 8px;
                                        "
                                    >
                                        PLACE OF DONATION:
                                    </td>
                                    <td class="border-b"></td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>

                <p class="text-10 bold mt-3 text-center">
                    *THANK YOU FOR DONATING YOUR BLOOD AND FOR HELPING THE
                    PHILIPPINE RED CROSS MAINTAIN A SAFE BLOOD SUPPLY*
                </p>
            </div>
        </div>
    </body>
</html>
