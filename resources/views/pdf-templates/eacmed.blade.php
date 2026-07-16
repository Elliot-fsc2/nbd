<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Blood Donor History Questionnaire</title>
    <style>
        @page {
            size: A4;
            margin: 15px 20px;
        }
        body {
            font-family: 'Helvetica', 'Arial', sans-serif;
            font-size: 8px;
            color: #000;
            line-height: 1.15;
            margin: 0;
            padding: 0;
        }
        .page-break {
            page-break-before: always;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 4px;
        }
        td {
            padding: 2.5px 4px;
            vertical-align: middle;
            font-size: 8px;
        }
        .border-all {
            border: 1px solid #000;
        }
        .border-cell {
            border: 1px solid #000;
        }
        .bg-gray {
            background-color: #e5e5e5;
        }
        .bg-light-gray {
            background-color: #f5f5f5;
        }
        .text-center {
            text-align: center;
        }
        .text-right {
            text-align: right;
        }
        .font-bold {
            font-weight: bold;
        }
        .header-table {
            width: 100%;
            border: none;
            margin-bottom: 5px;
        }
        .header-table td {
            border: none;
            padding: 0;
        }
        .logo-box {
            text-align: center;
            width: 85px;
        }
        .logo-box img {
            width: 75px;
            height: auto;
        }
        .facility-title {
            font-size: 11px;
            font-weight: bold;
            text-transform: uppercase;
        }
        .facility-subtext {
            font-size: 7.5px;
            color: #222;
        }
        .facility-section {
            font-size: 8.5px;
            font-weight: bold;
            margin-top: 3px;
        }
        .form-title {
            font-size: 10px;
            font-weight: bold;
            background-color: #000;
            color: #fff;
            text-align: center;
            padding: 3px 0;
            margin-top: 3px;
            letter-spacing: 0.5px;
        }
        .section-banner {
            font-size: 8px;
            font-weight: bold;
            background-color: #d3d3d3;
            border: 1px solid #000;
            padding: 2px 5px;
            margin-top: 4px;
            margin-bottom: 3px;
            text-transform: uppercase;
        }
        .checkbox-box {
            display: inline-block;
            width: 8px;
            height: 8px;
            border: 1px solid #000;
            margin-right: 3px;
            text-align: center;
            line-height: 7px;
            font-size: 7px;
            font-weight: bold;
            vertical-align: middle;
        }
        .checkbox-label {
            margin-right: 12px;
            vertical-align: middle;
        }
        .question-table {
            width: 100%;
            margin-top: 3px;
        }
        .question-table td {
            border: 1px solid #000;
            padding: 2px 4px;
        }
        .question-header {
            font-weight: bold;
            background-color: #e5e5e5;
            text-align: center;
        }
        .question-num {
            width: 5%;
            text-align: center;
            font-weight: bold;
        }
        .question-text {
            width: 79%;
        }
        .question-check {
            width: 8%;
            text-align: center;
        }
        .category-row {
            font-weight: bold;
            background-color: #f0f0f0;
        }
        .cue-box {
            border: 2px dashed #000;
            padding: 5px;
            margin-top: 5px;
            background-color: #fff;
        }
        .cue-title {
            font-weight: bold;
            font-size: 8px;
            margin-bottom: 2px;
        }
    </style>
</head>
<body>

    <table class="header-table">
        <tr>
            <td style="width: 15%; text-align: left; vertical-align: middle;">
                <div class="logo-box">
                    <img src="{{ public_path('images/eacmed.png') }}" alt="EACMed Logo" style="width:75px;height:auto;">
                </div>
            </td>
            <td style="width: 85%; text-align: center; vertical-align: middle; padding-left: 10px;">
                <div class="facility-title">{{ $data['facility_name'] }}</div>
                <div class="facility-subtext">
                    {{ $data['facility_address'] }} | Tel: {{ $data['facility_contact'] }}
                </div>
                <div class="facility-section">{{ $data['facility_department'] }}</div>
            </td>
        </tr>
    </table>

    <div class="form-title">BLOOD DONOR HISTORY QUESTIONNAIRE</div>

    <table class="border-all" style="margin-top: 3px;">
        <tr>
            <td class="bg-light-gray font-bold" style="width: 15%; border: 1px solid #000;">Date:</td>
            <td colspan="5" style="border: 1px solid #000;">{{ $data['form_date'] }}</td>
        </tr>
        <tr>
            <td class="bg-light-gray font-bold" style="width: 15%; border: 1px solid #000;">Last Name:</td>
            <td style="width: 18%; border: 1px solid #000;">{{ $data['personal']['last_name'] }}</td>
            <td class="bg-light-gray font-bold" style="width: 15%; border: 1px solid #000;">First Name:</td>
            <td style="width: 18%; border: 1px solid #000;">{{ $data['personal']['first_name'] }}</td>
            <td class="bg-light-gray font-bold" style="width: 15%; border: 1px solid #000;">Middle Name:</td>
            <td style="width: 19%; border: 1px solid #000;">{{ $data['personal']['middle_name'] }}</td>
        </tr>
        <tr>
            <td class="bg-light-gray font-bold" style="border: 1px solid #000;">Birthdate (mm/dd/yyyy):</td>
            <td style="border: 1px solid #000;">{{ $data['personal']['birthdate'] }}</td>
            <td class="bg-light-gray font-bold" style="border: 1px solid #000;">Age:</td>
            <td style="border: 1px solid #000;">{{ $data['personal']['age'] }}</td>
            <td class="bg-light-gray font-bold" style="border: 1px solid #000;">Gender:</td>
            <td style="border: 1px solid #000;">
                <span class="checkbox-box">{{ strtolower($data['personal']['gender'] ?? '') == 'male' ? 'X' : '' }}</span> <span class="checkbox-label">Male</span>
                <span class="checkbox-box">{{ strtolower($data['personal']['gender'] ?? '') == 'female' ? 'X' : '' }}</span> <span class="checkbox-label">Female</span>
            </td>
        </tr>
        <tr>
            <td class="bg-light-gray font-bold" style="border: 1px solid #000;">Civil Status:</td>
            <td style="border: 1px solid #000;">{{ $data['personal']['civil_status'] }}</td>
            <td class="bg-light-gray font-bold" style="border: 1px solid #000;">Contact No.:</td>
            <td colspan="3" style="border: 1px solid #000;">{{ $data['personal']['contact_no'] }}</td>
        </tr>
        <tr>
            <td class="bg-light-gray font-bold" style="border: 1px solid #000;">E-mail address:</td>
            <td colspan="2" style="border: 1px solid #000;">{{ $data['personal']['email'] }}</td>
            <td class="bg-light-gray font-bold" style="border: 1px solid #000;">Nationality:</td>
            <td colspan="2" style="border: 1px solid #000;">{{ $data['personal']['nationality'] }}</td>
        </tr>
        <tr>
            <td class="bg-light-gray font-bold" style="border: 1px solid #000;">Occupation:</td>
            <td colspan="5" style="border: 1px solid #000;">{{ $data['personal']['occupation'] }}</td>
        </tr>
    </table>

    <div class="section-banner">Preferred Mailing Address</div>
    <table class="border-all">
        <tr>
            <td class="bg-light-gray font-bold" style="width: 25%; border: 1px solid #000;">Number, Street, Subdivision:</td>
            <td colspan="3" style="border: 1px solid #000;">{{ $data['personal']['address_street'] }}</td>
        </tr>
        <tr>
            <td class="bg-light-gray font-bold" style="border: 1px solid #000;">Barangay:</td>
            <td style="width: 25%; border: 1px solid #000;">{{ $data['personal']['address_barangay'] }}</td>
            <td class="bg-light-gray font-bold" style="width: 20%; border: 1px solid #000;">Town / District:</td>
            <td style="width: 30%; border: 1px solid #000;">{{ $data['personal']['address_town'] }}</td>
        </tr>
        <tr>
            <td class="bg-light-gray font-bold" style="border: 1px solid #000;">City:</td>
            <td style="border: 1px solid #000;">{{ $data['personal']['address_city'] }}</td>
            <td class="bg-light-gray font-bold" style="border: 1px solid #000;">Province:</td>
            <td style="border: 1px solid #000;">{{ $data['personal']['address_province'] }}</td>
        </tr>
        <tr>
            <td class="bg-light-gray font-bold" style="border: 1px solid #000;">Zip Code:</td>
            <td colspan="3" style="border: 1px solid #000;">{{ $data['personal']['address_zip_code'] }}</td>
        </tr>
    </table>

    <table class="border-all" style="margin-top: 3px;">
        <tr>
            <td style="width: 50%;">
                <span class="font-bold">Type of Donor:</span><br/>
                <span class="checkbox-box"></span> <span class="checkbox-label">New</span>
                <span class="checkbox-box"></span> <span class="checkbox-label">Repeat</span>
                <span class="checkbox-box"></span> <span class="checkbox-label">First Time</span>
                <span class="checkbox-box"></span> <span class="checkbox-label">Lapsed</span>
                <span class="checkbox-box"></span> <span class="checkbox-label">Retained</span>
            </td>
            <td style="width: 50%;">
                <span class="font-bold">Method of Collection:</span><br/>
                <span class="checkbox-box"></span> <span class="checkbox-label">Whole Blood (Conventional)</span>
                <span class="checkbox-box"></span> <span class="checkbox-label">Apheresis</span>
                <span class="checkbox-box"></span> <span class="checkbox-label">Autologous</span>
            </td>
        </tr>
    </table>

    <div class="section-banner">PART I – DONOR HISTORY QUESTIONS</div>

    <table class="question-table">
        <tr class="question-header">
            <td style="width: 5%;">No.</td>
            <td style="width: 75%; text-align: left;">Are you:</td>
            <td style="width: 10%;">YES</td>
            <td style="width: 10%;">NO</td>
        </tr>
        <tr>
            <td class="question-num">1</td>
            <td class="question-text">Feeling healthy and well today?</td>
            <td class="question-check"><span class="checkbox-box"></span></td>
            <td class="question-check"><span class="checkbox-box"></span></td>
        </tr>
        <tr>
            <td class="question-num">2</td>
            <td class="question-text">Currently taking any medication?</td>
            <td class="question-check"><span class="checkbox-box"></span></td>
            <td class="question-check"><span class="checkbox-box"></span></td>
        </tr>
        <tr>
            <td class="question-num">3</td>
            <td class="question-text">Currently taking any antibiotic?</td>
            <td class="question-check"><span class="checkbox-box"></span></td>
            <td class="question-check"><span class="checkbox-box"></span></td>
        </tr>
        <tr>
            <td class="question-num">4</td>
            <td class="question-text">Have you taken any medications listed on the Deferral List?</td>
            <td class="question-check"><span class="checkbox-box"></span></td>
            <td class="question-check"><span class="checkbox-box"></span></td>
        </tr>
        <tr>
            <td class="question-num">5</td>
            <td class="question-text">Have you read the educational material provided by the blood service facility?</td>
            <td class="question-check"><span class="checkbox-box"></span></td>
            <td class="question-check"><span class="checkbox-box"></span></td>
        </tr>
        <tr class="category-row">
            <td colspan="4">[B] In the past 3 days</td>
        </tr>
        <tr>
            <td class="question-num">6</td>
            <td class="question-text">Have you taken aspirin or anything that has aspirin in it?</td>
            <td class="question-check"><span class="checkbox-box"></span></td>
            <td class="question-check"><span class="checkbox-box"></span></td>
        </tr>
        <tr class="category-row">
            <td colspan="4">[C] For Female donors only: In the past 6 weeks</td>
        </tr>
        <tr>
            <td class="question-num">7</td>
            <td class="question-text">Have you been pregnant or are you pregnant now?</td>
            <td class="question-check"><span class="checkbox-box"></span></td>
            <td class="question-check"><span class="checkbox-box"></span></td>
        </tr>
        <tr class="category-row">
            <td colspan="4">[D] In the past 8 weeks</td>
        </tr>
        <tr>
            <td class="question-num">8</td>
            <td class="question-text">Have you donated blood, platelets or plasma?</td>
            <td class="question-check"><span class="checkbox-box"></span></td>
            <td class="question-check"><span class="checkbox-box"></span></td>
        </tr>
        <tr class="category-row">
            <td colspan="4">[E] In the past 12 months</td>
        </tr>
        <tr>
            <td class="question-num">9</td>
            <td class="question-text">Have you had a blood transfusion?</td>
            <td class="question-check"><span class="checkbox-box"></span></td>
            <td class="question-check"><span class="checkbox-box"></span></td>
        </tr>
        <tr>
            <td class="question-num">10</td>
            <td class="question-text">Have you had a surgical operation or dental extraction?</td>
            <td class="question-check"><span class="checkbox-box"></span></td>
            <td class="question-check"><span class="checkbox-box"></span></td>
        </tr>
        <tr>
            <td class="question-num">11</td>
            <td class="question-text">Have you had a tattoo, ear or body piercing, accidental needle-stick injury or acupuncture?</td>
            <td class="question-check"><span class="checkbox-box"></span></td>
            <td class="question-check"><span class="checkbox-box"></span></td>
        </tr>
        <tr>
            <td class="question-num">12</td>
            <td class="question-text">Have you had sexual contact with a person who has Hepatitis B?</td>
            <td class="question-check"><span class="checkbox-box"></span></td>
            <td class="question-check"><span class="checkbox-box"></span></td>
        </tr>
        <tr>
            <td class="question-num">13</td>
            <td class="question-text">Have you had sexual contact with a person who has ever used needles to take drugs?</td>
            <td class="question-check"><span class="checkbox-box"></span></td>
            <td class="question-check"><span class="checkbox-box"></span></td>
        </tr>
        <tr>
            <td class="question-num">14</td>
            <td class="question-text">Have you had sexual contact with a person who has HIV/AIDS?</td>
            <td class="question-check"><span class="checkbox-box"></span></td>
            <td class="question-check"><span class="checkbox-box"></span></td>
        </tr>
        <tr class="category-row">
            <td colspan="4">[F] Have you ever:</td>
        </tr>
        <tr>
            <td class="question-num">15</td>
            <td class="question-text">Had a positive test for HIV, Hepatitis B, Hepatitis C, Syphilis or Malaria?</td>
            <td class="question-check"><span class="checkbox-box"></span></td>
            <td class="question-check"><span class="checkbox-box"></span></td>
        </tr>
        <tr>
            <td class="question-num">16</td>
            <td class="question-text">Taken money, drugs or other payment for sex?</td>
            <td class="question-check"><span class="checkbox-box"></span></td>
            <td class="question-check"><span class="checkbox-box"></span></td>
        </tr>
        <tr>
            <td class="question-num">17</td>
            <td class="question-text">Had male-to-male sexual contact?</td>
            <td class="question-check"><span class="checkbox-box"></span></td>
            <td class="question-check"><span class="checkbox-box"></span></td>
        </tr>
        <tr>
            <td class="question-num">18</td>
            <td class="question-text">Had sexual contact with a person who has hemophilia or a related clotting disorder?</td>
            <td class="question-check"><span class="checkbox-box"></span></td>
            <td class="question-check"><span class="checkbox-box"></span></td>
        </tr>
        <tr>
            <td class="question-num">19</td>
            <td class="question-text">Used needles to take drugs, steroids or anything not prescribed by your doctor?</td>
            <td class="question-check"><span class="checkbox-box"></span></td>
            <td class="question-check"><span class="checkbox-box"></span></td>
        </tr>
        <tr>
            <td class="question-num">20</td>
            <td class="question-text">Taken clotting factor concentrates for hemophilia or other clotting disorder?</td>
            <td class="question-check"><span class="checkbox-box"></span></td>
            <td class="question-check"><span class="checkbox-box"></span></td>
        </tr>
        <tr>
            <td class="question-num">21</td>
            <td class="question-text">Had hepatitis?</td>
            <td class="question-check"><span class="checkbox-box"></span></td>
            <td class="question-check"><span class="checkbox-box"></span></td>
        </tr>
        <tr>
            <td class="question-num">22</td>
            <td class="question-text">Had malaria?</td>
            <td class="question-check"><span class="checkbox-box"></span></td>
            <td class="question-check"><span class="checkbox-box"></span></td>
        </tr>
        <tr>
            <td class="question-num">23</td>
            <td class="question-text">Had any type of cancer, including leukemia?</td>
            <td class="question-check"><span class="checkbox-box"></span></td>
            <td class="question-check"><span class="checkbox-box"></span></td>
        </tr>
        <tr>
            <td class="question-num">24</td>
            <td class="question-text">Had any problems with your heart or lungs?</td>
            <td class="question-check"><span class="checkbox-box"></span></td>
            <td class="question-check"><span class="checkbox-box"></span></td>
        </tr>
        <tr>
            <td class="question-num">25</td>
            <td class="question-text">Had a bleeding condition or blood disease?</td>
            <td class="question-check"><span class="checkbox-box"></span></td>
            <td class="question-check"><span class="checkbox-box"></span></td>
        </tr>
        <tr>
            <td class="question-num">26</td>
            <td class="question-text">Had a seizure disorder or taken any seizure medication?</td>
            <td class="question-check"><span class="checkbox-box"></span></td>
            <td class="question-check"><span class="checkbox-box"></span></td>
        </tr>
        <tr>
            <td class="question-num">27</td>
            <td class="question-text">Had a positive test for Syphilis or been treated for Syphilis?</td>
            <td class="question-check"><span class="checkbox-box"></span></td>
            <td class="question-check"><span class="checkbox-box"></span></td>
        </tr>
        <tr>
            <td class="question-num">28</td>
            <td class="question-text">Lived in or visited a country where malaria is endemic?</td>
            <td class="question-check"><span class="checkbox-box"></span></td>
            <td class="question-check"><span class="checkbox-box"></span></td>
        </tr>
        <tr>
            <td class="question-num">29</td>
            <td class="question-text">Lived in the United Kingdom (England, Northern Ireland, Scotland, Wales, Isle of Man or the Falkland Islands) for 3 months or more from 1980 to 1996?</td>
            <td class="question-check"><span class="checkbox-box"></span></td>
            <td class="question-check"><span class="checkbox-box"></span></td>
        </tr>
        <tr>
            <td class="question-num">30</td>
            <td class="question-text">Lived in Europe for 5 years or more from 1980 to present?</td>
            <td class="question-check"><span class="checkbox-box"></span></td>
            <td class="question-check"><span class="checkbox-box"></span></td>
        </tr>
    </table>

    <div class="section-banner">CONFIDENTIAL UNIT EXCLUSION (CUE)</div>
    <div class="cue-box">
        <div class="cue-title">CONFIDENTIAL</div>
        <p style="margin: 0 0 3px 0; font-size: 7.5px;">
            If you feel that your blood should not be used for transfusion, please check the box below. Your blood will be discarded and you will receive appropriate medical counseling. This information will be kept strictly confidential.
        </p>
        <p style="margin: 0; font-size: 7.5px;">
            <span class="checkbox-box"></span> <span class="checkbox-label">My blood may not be safe for transfusion.</span>
        </p>
    </div>

    <div style="border: 1px solid #000; padding: 5px; margin-top: 5px; text-align: justify; font-size: 7.5px;">
        <p style="margin: 0;">
            I certify that I have read and understood the donor educational material provided. I have truthfully answered the above questions to the best of my knowledge. I understand that my blood will be tested for blood type, hemoglobin, malaria, syphilis, Hepatitis B, Hepatitis C, and HIV. I consent to the collection and testing of my blood for transfusion purposes. I understand that if I am found to have a reactive test result, I will be notified and referred for appropriate medical follow-up.
        </p>
    </div>

    <table style="width: 100%; margin-top: 5px;">
        <tr>
            <td style="width: 50%; border: 1px solid #000; padding: 4px; vertical-align: top;">
                <strong>Donor's Printed Name:</strong><br/><br/>
                <strong>Donor's Signature:</strong><br/><br/>
                <strong>Date:</strong>
            </td>
            <td style="width: 50%; border: 1px solid #000; padding: 4px; vertical-align: top;">
                <strong>Witness Printed Name:</strong><br/><br/>
                <strong>Witness Signature:</strong><br/><br/>
                <strong>Date:</strong>
            </td>
        </tr>
    </table>

    <div class="section-banner" style="margin-top: 5px;">FOR BLOOD BANK USE ONLY</div>
    <table class="border-all">
        <tr class="bg-gray">
            <td colspan="4" style="font-weight: bold;">Physical Examination</td>
        </tr>
        <tr>
            <td style="width: 25%; border: 1px solid #000;">Body Weight: ________</td>
            <td style="width: 25%; border: 1px solid #000;">Blood Pressure: ________</td>
            <td style="width: 25%; border: 1px solid #000;">Pulse Rate: ________</td>
            <td style="width: 25%; border: 1px solid #000;">Temperature: ________</td>
        </tr>
        <tr>
            <td style="border: 1px solid #000;">General Appearance: ____</td>
            <td style="border: 1px solid #000;">Skin: _______________</td>
            <td style="border: 1px solid #000;">HEENT: _____________</td>
            <td style="border: 1px solid #000;">Heart & Lungs: _______</td>
        </tr>
        <tr>
            <td colspan="2" style="border: 1px solid #000; vertical-align: top; height: 25px;">
                <strong>Remarks:</strong><br/>
                <span class="checkbox-box"></span> Accepted<br/>
                <span class="checkbox-box"></span> Temporarily Deferred<br/>
                <span class="checkbox-box"></span> Permanently Deferred
            </td>
            <td colspan="2" style="border: 1px solid #000; vertical-align: top;">
                <strong>Reason for Deferral:</strong><br/><br/>
                ________________________________
            </td>
        </tr>
        <tr>
            <td colspan="2" style="border: 1px solid #000; text-align: center; height: 20px; vertical-align: bottom;">
                <strong>Blood Bank Officer:</strong> __________________
            </td>
            <td colspan="2" style="border: 1px solid #000; text-align: center; vertical-align: middle; background-color: #fafafa;">
                [ Place Barcode Sticker ]
            </td>
        </tr>
    </table>

    <table style="width: 100%; margin-top: 5px;">
        <tr>
            <td style="width: 50%; vertical-align: top;">
                <table style="width: 100%; border: none; margin: 0;">
                    <tr class="bg-gray"><td colspan="2" style="border: 1px solid #000;"><strong>FOR SCREENING USE ONLY</strong></td></tr>
                    <tr style="font-weight: bold; text-align: center;">
                        <td style="width: 50%; border: 1px solid #000;">TEST</td>
                        <td style="width: 50%; border: 1px solid #000;">RESULT</td>
                    </tr>
                    <tr><td style="border: 1px solid #000;">Blood Type</td><td style="border: 1px solid #000;">&nbsp;</td></tr>
                    <tr><td style="border: 1px solid #000;">Hemoglobin</td><td style="border: 1px solid #000;">&nbsp;</td></tr>
                    <tr><td style="border: 1px solid #000;">HBsAg</td><td style="border: 1px solid #000;">&nbsp;</td></tr>
                    <tr><td style="border: 1px solid #000;">RPR</td><td style="border: 1px solid #000;">&nbsp;</td></tr>
                    <tr><td style="border: 1px solid #000;">HIV</td><td style="border: 1px solid #000;">&nbsp;</td></tr>
                    <tr><td style="border: 1px solid #000;">HCV</td><td style="border: 1px solid #000;">&nbsp;</td></tr>
                    <tr><td style="border: 1px solid #000;">Malaria</td><td style="border: 1px solid #000;">&nbsp;</td></tr>
                    <tr><td style="border: 1px solid #000;">Antibody Screening</td><td style="border: 1px solid #000;">&nbsp;</td></tr>
                    <tr><td colspan="2" style="border: 1px solid #000; text-align: center; height: 20px; vertical-align: bottom;"><strong>Screened by:</strong> ________________________</td></tr>
                </table>
            </td>
            <td style="width: 50%; vertical-align: top;">
                <table style="width: 100%; border: none; margin: 0;">
                    <tr class="bg-gray"><td colspan="2" style="border: 1px solid #000;"><strong>FOR PHLEBOTOMY USE ONLY</strong></td></tr>
                    <tr><td colspan="2" style="border: 1px solid #000;"><strong>Blood Bag Size:</strong><br/>
                        <span class="checkbox-box"></span> Single &nbsp;&nbsp; <span class="checkbox-box"></span> Double &nbsp;&nbsp; <span class="checkbox-box"></span> Triple
                    </td></tr>
                    <tr><td colspan="2" style="border: 1px solid #000;"><strong>Segment Number:</strong> _________________________</td></tr>
                    <tr><td style="width: 50%; border: 1px solid #000;"><strong>Time Started:</strong><br/>_____________</td><td style="width: 50%; border: 1px solid #000;"><strong>Time Finished:</strong><br/>_____________</td></tr>
                    <tr style="height: 30px;"><td colspan="2" style="border: 1px solid #000; text-align: center; vertical-align: bottom;"><strong>Phlebotomist:</strong> _________________________</td></tr>
                    <tr><td colspan="2" style="border: 1px solid #000; text-align: center; height: 30px; vertical-align: middle; background-color: #fafafa;">[ Place Barcode Sticker ]</td></tr>
                </table>
            </td>
        </tr>
    </table>

</body>
</html>