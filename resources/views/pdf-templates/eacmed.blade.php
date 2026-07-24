<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Blood Donor History Questionnaire</title>
    <style>
        @page {
            margin: 15px 25px;
        }

        body {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 10px;
            color: #000;
            line-height: 1.2;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            padding: 3px 4px;
            vertical-align: top;
        }

        .bordered, .bordered th, .bordered td {
            border: 1px solid #000;
        }

        .text-center { text-align: center; }
        .text-right { text-align: right; }
        .text-left { text-align: left; }
        .font-bold { font-weight: bold; }
        .uppercase { text-transform: uppercase; }

        .checkbox-box {
            display: inline-block;
            width: 10px;
            height: 10px;
            border: 1px solid #000;
            margin-right: 3px;
            text-align: center;
            line-height: 9px;
            font-size: 9px;
        }

        .header-title {
            font-size: 13px;
            font-weight: bold;
        }

        .header-sub {
            font-size: 11px;
            font-weight: bold;
        }

        .section-header {
            background-color: #f0f0f0;
            font-weight: bold;
        }

        .cut-line {
            margin: 15px 0;
            border-bottom: 1px dashed #000;
            position: relative;
            text-align: left;
        }

        .cut-line span {
            position: absolute;
            top: -9px;
            left: 10px;
            background: #fff;
            padding: 0 5px;
            font-size: 14px;
        }

        .line-field {
            border-bottom: 1px solid #000;
            display: inline-block;
        }

        .barcode-box {
            border: 1px solid #000;
            border-radius: 8px;
            height: 45px;
            width: 250px;
            text-align: center;
            line-height: 45px;
            font-size: 9px;
            color: #666;
        }

        .page-break {
            page-break-after: always;
        }
    </style>
</head>
<body>

    <table style="margin-bottom: 5px;">
        <tr>
            <td width="15%" class="text-center">
                <div style="font-size: 8px; font-weight: bold; border: 1px solid #000; border-radius: 50%; width: 55px; height: 55px; line-height: 55px; margin: 0 auto;">EACMed</div>
            </td>
            <td width="70%" class="text-center">
                <div class="header-title">EMILIO AGUINALDO COLLEGE MEDICAL CENTER CAVITE</div>
                <div>Brgy. Salitran II, City of Dasmariñas, Cavite</div>
                <div>(046) 416 - 3010</div>
                <div class="header-sub" style="margin-top: 5px;">Department of Laboratory Medicine - Blood Bank Section</div>
                <div class="header-title" style="margin-top: 5px;">BLOOD DONOR HISTORY QUESTIONNAIRE</div>
            </td>
            <td width="15%" valign="top">
                <table class="bordered">
                    <tr>
                        <td class="font-bold text-center" style="background:#eee;">Date</td>
                    </tr>
                    <tr>
                        <td class="text-center" style="height: 15px;">{{ $data['form_date'] ?? '' }}</td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>

    <table class="bordered" style="margin-bottom: 5px;">
        <tr>
            <td width="33%">
                <strong>Last Name</strong><br>
                {{ $data['personal']['last_name'] ?? '' }}
            </td>
            <td width="33%">
                <strong>First Name</strong><br>
                {{ $data['personal']['first_name'] ?? '' }}
            </td>
            <td width="34%">
                <strong>Middle Name</strong><br>
                {{ $data['personal']['middle_name'] ?? '' }}
            </td>
        </tr>
        <tr>
            <td width="23%">
                <strong>Birthdate</strong> <em>(mm/dd/yyyy)</em><br>
                {{ $data['personal']['birthdate'] ? \Carbon\Carbon::parse($data['personal']['birthdate'])->format('m / d / Y') : '/ /' }}
            </td>
            <td width="10%">
                <strong>Age</strong><br>
                {{ $data['personal']['age'] ?? '' }}
            </td>
            <td width="20%">
                <strong>Gender</strong><br>
                <span class="checkbox-box">{{ ($data['personal']['gender'] ?? '') == 'Male' ? '✓' : '' }}</span> Male
                &nbsp;
                <span class="checkbox-box">{{ ($data['personal']['gender'] ?? '') == 'Female' ? '✓' : '' }}</span> Female
            </td>
            <td width="22%">
                <strong>Civil Status</strong><br>
                {{ $data['personal']['civil_status'] ?? '' }}
            </td>
            <td width="25%">
                <strong>Contact No.</strong><br>
                {{ $data['personal']['contact_no'] ?? '' }}
            </td>
        </tr>
        <tr>
            <td>
                <strong>E-mail address</strong><br>
                {{ $data['personal']['email'] ?? '' }}
            </td>
            <td>
                <strong>Nationality</strong><br>
                {{ $data['personal']['nationality'] ?? '' }}
            </td>
            <td colspan="3">
                <strong>Occupation</strong><br>
                {{ $data['personal']['occupation'] ?? '' }}
            </td>
        </tr>
        <tr>
            <td colspan="5">
                <strong>Preferred Mailing Address</strong><br>
                <table width="100%" style="text-align: center; margin-top: 5px;">
                    <tr>
                        <td width="33%" style="border-bottom: 1px solid #000;">{{ $data['personal']['address_street'] ?? '' }}</td>
                        <td width="33%" style="border-bottom: 1px solid #000;">{{ $data['personal']['address_barangay'] ?? '' }}</td>
                        <td width="34%" style="border-bottom: 1px solid #000;">{{ $data['personal']['address_town'] ?? '' }}</td>
                    </tr>
                    <tr style="font-style: italic; font-size: 8px;">
                        <td>Number, Street, Subdivision</td>
                        <td>Barangay</td>
                        <td>Town/District</td>
                    </tr>
                </table>
                <table width="100%" style="text-align: center; margin-top: 5px;">
                    <tr>
                        <td width="33%" style="border-bottom: 1px solid #000;">{{ $data['personal']['address_city'] ?? '' }}</td>
                        <td width="33%" style="border-bottom: 1px solid #000;">{{ $data['personal']['address_province'] ?? '' }}</td>
                        <td width="34%" style="border-bottom: 1px solid #000;">{{ $data['personal']['address_zip_code'] ?? '' }}</td>
                    </tr>
                    <tr style="font-style: italic; font-size: 8px;">
                        <td>City</td>
                        <td>Province</td>
                        <td>Zip Code</td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td colspan="5">
                <table width="100%">
                    <tr>
                        <td width="20%"><strong>Type of Donor:</strong></td>
                        <td>
                            <span class="checkbox-box">{{ ($donor->donor_type ?? '') == 'Walk-in' ? '✓' : '' }}</span> Walk-in/Voluntary
                            &nbsp;&nbsp;
                            <span class="checkbox-box">{{ ($donor->donor_type ?? '') == 'Autologous' ? '✓' : '' }}</span> Autologous
                            &nbsp;&nbsp;
                            <span class="checkbox-box">{{ ($donor->donor_type ?? '') == 'MBD' ? '✓' : '' }}</span> MBD
                            <br>
                            <span class="checkbox-box">{{ ($donor->donor_status ?? '') == 'New' ? '✓' : '' }}</span> New
                            &nbsp;&nbsp;
                            <span class="checkbox-box">{{ ($donor->donor_status ?? '') == 'Repeat' ? '✓' : '' }}</span> Repeat
                            &nbsp;&nbsp;
                            <span class="checkbox-box">{{ ($donor->donor_status ?? '') == 'First Time' ? '✓' : '' }}</span> First Time
                            &nbsp;&nbsp;
                            <span class="checkbox-box">{{ ($donor->donor_status ?? '') == 'Lapsed' ? '✓' : '' }}</span> Lapsed
                            &nbsp;&nbsp;
                            <span class="checkbox-box">{{ ($donor->donor_status ?? '') == 'Retained' ? '✓' : '' }}</span> Retained
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td colspan="5">
                <table width="100%">
                    <tr>
                        <td width="20%"><strong>Method of Collection:</strong></td>
                        <td>
                            <span class="checkbox-box">{{ ($donor->collection_method ?? '') == 'Whole Blood' ? '✓' : '' }}</span> Whole Blood (Conventional)
                            &nbsp;&nbsp;&nbsp;&nbsp;
                            <span class="checkbox-box">{{ ($donor->collection_method ?? '') == 'Apheresis' ? '✓' : '' }}</span> Apheresis
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>

    <div style="font-style: italic; font-size: 9px; margin-bottom: 3px;">
        <strong>Instructions:</strong> All donors must read the donor educational material provided by the Blood Service Facility staff before answering.
    </div>

    <table class="bordered">
        <thead>
            <tr>
                <th></th>
                <th width="8%" class="text-center">YES</th>
                <th width="8%" class="text-center">NO</th>
            </tr>
        </thead>
        <tbody>
            <tr class="section-header"><td colspan="3">Are you</td></tr>
            <tr>
                <td>1. Feeling healthy today?</td>
                <td class="text-center">{{ ($answers[1] ?? '') == 'YES' ? '✓' : '' }}</td>
                <td class="text-center">{{ ($answers[1] ?? '') == 'NO' ? '✓' : '' }}</td>
            </tr>
            <tr>
                <td>2. Currently taking medication?</td>
                <td class="text-center">{{ ($answers[2] ?? '') == 'YES' ? '✓' : '' }}</td>
                <td class="text-center">{{ ($answers[2] ?? '') == 'NO' ? '✓' : '' }}</td>
            </tr>
            <tr>
                <td>3. Have you taken any medication from the deferral list?</td>
                <td class="text-center">{{ ($answers[3] ?? '') == 'YES' ? '✓' : '' }}</td>
                <td class="text-center">{{ ($answers[3] ?? '') == 'NO' ? '✓' : '' }}</td>
            </tr>
            <tr>
                <td>4. Have you received any vaccination?</td>
                <td class="text-center">{{ ($answers[4] ?? '') == 'YES' ? '✓' : '' }}</td>
                <td class="text-center">{{ ($answers[4] ?? '') == 'NO' ? '✓' : '' }}</td>
            </tr>

            <tr class="section-header"><td colspan="3">In the past 3 days</td></tr>
            <tr>
                <td>5. Have you taken aspirin or anything that has aspirin in it?</td>
                <td class="text-center">{{ ($answers[5] ?? '') == 'YES' ? '✓' : '' }}</td>
                <td class="text-center">{{ ($answers[5] ?? '') == 'NO' ? '✓' : '' }}</td>
            </tr>

            <tr class="section-header"><td colspan="3">For FEMALE Donors only:<br>In the past 1 and ½ months (6 weeks)</td></tr>
            <tr>
                <td>
                    6. Have you been pregnant or are you pregnant now?<br>
                    Last menstrual period: <span class="line-field" style="width: 250px;">{{ $donor->lmp ?? '' }}</span>
                </td>
                <td class="text-center">{{ ($answers[6] ?? '') == 'YES' ? '✓' : '' }}</td>
                <td class="text-center">{{ ($answers[6] ?? '') == 'NO' ? '✓' : '' }}</td>
            </tr>

            <tr class="section-header"><td colspan="3">In the past 12 weeks</td></tr>
            <tr>
                <td>7. Have you donated blood, platelet or plasma?</td>
                <td class="text-center">{{ ($answers[7] ?? '') == 'YES' ? '✓' : '' }}</td>
                <td class="text-center">{{ ($answers[7] ?? '') == 'NO' ? '✓' : '' }}</td>
            </tr>

            <tr class="section-header"><td colspan="3">In the past 12 months</td></tr>
            <tr>
                <td>8. Have you had a blood transfusion?</td>
                <td class="text-center">{{ ($answers[8] ?? '') == 'YES' ? '✓' : '' }}</td>
                <td class="text-center">{{ ($answers[8] ?? '') == 'NO' ? '✓' : '' }}</td>
            </tr>
            <tr>
                <td>9. Have you had surgical operation or dental extraction?</td>
                <td class="text-center">{{ ($answers[9] ?? '') == 'YES' ? '✓' : '' }}</td>
                <td class="text-center">{{ ($answers[9] ?? '') == 'NO' ? '✓' : '' }}</td>
            </tr>
            <tr>
                <td>10. Have you had a tattoo, ear or body piercing, accidental contact with blood, needle-stick injury, and acupuncture?</td>
                <td class="text-center">{{ ($answers[10] ?? '') == 'YES' ? '✓' : '' }}</td>
                <td class="text-center">{{ ($answers[10] ?? '') == 'NO' ? '✓' : '' }}</td>
            </tr>
            <tr>
                <td>11. Have you had sexual contact with high risk individual?</td>
                <td class="text-center">{{ ($answers[11] ?? '') == 'YES' ? '✓' : '' }}</td>
                <td class="text-center">{{ ($answers[11] ?? '') == 'NO' ? '✓' : '' }}</td>
            </tr>
            <tr>
                <td>12. Have you had sexual contact with anyone in exchange for material or monetary gain?</td>
                <td class="text-center">{{ ($answers[12] ?? '') == 'YES' ? '✓' : '' }}</td>
                <td class="text-center">{{ ($answers[12] ?? '') == 'NO' ? '✓' : '' }}</td>
            </tr>
            <tr>
                <td>13. Have you had sexual contact with a person who has worked abroad?</td>
                <td class="text-center">{{ ($answers[13] ?? '') == 'YES' ? '✓' : '' }}</td>
                <td class="text-center">{{ ($answers[13] ?? '') == 'NO' ? '✓' : '' }}</td>
            </tr>
            <tr>
                <td>14. Have you engaged in casual sex?</td>
                <td class="text-center">{{ ($answers[14] ?? '') == 'YES' ? '✓' : '' }}</td>
                <td class="text-center">{{ ($answers[14] ?? '') == 'NO' ? '✓' : '' }}</td>
            </tr>
            <tr>
                <td>15. Have you lived with a person who has hepatitis?</td>
                <td class="text-center">{{ ($answers[15] ?? '') == 'YES' ? '✓' : '' }}</td>
                <td class="text-center">{{ ($answers[15] ?? '') == 'NO' ? '✓' : '' }}</td>
            </tr>
            <tr>
                <td>16. Have you been imprisoned?</td>
                <td class="text-center">{{ ($answers[16] ?? '') == 'YES' ? '✓' : '' }}</td>
                <td class="text-center">{{ ($answers[16] ?? '') == 'NO' ? '✓' : '' }}</td>
            </tr>
            <tr>
                <td>17. Have any of your relative had Creutzfeldt-Jacob (mAdCow) Disease?</td>
                <td class="text-center">{{ ($answers[17] ?? '') == 'YES' ? '✓' : '' }}</td>
                <td class="text-center">{{ ($answers[17] ?? '') == 'NO' ? '✓' : '' }}</td>
            </tr>

            <tr class="section-header"><td colspan="3">Have you ever</td></tr>
            <tr>
                <td>18. Lived outside your place of residence?</td>
                <td class="text-center">{{ ($answers[18] ?? '') == 'YES' ? '✓' : '' }}</td>
                <td class="text-center">{{ ($answers[18] ?? '') == 'NO' ? '✓' : '' }}</td>
            </tr>
            <tr>
                <td>19. Lived outside the Philippines?</td>
                <td class="text-center">{{ ($answers[19] ?? '') == 'YES' ? '✓' : '' }}</td>
                <td class="text-center">{{ ($answers[19] ?? '') == 'NO' ? '✓' : '' }}</td>
            </tr>
            <tr>
                <td>20. Used needles to take drugs, steroids, or anything not prescribed by your doctor?</td>
                <td class="text-center">{{ ($answers[20] ?? '') == 'YES' ? '✓' : '' }}</td>
                <td class="text-center">{{ ($answers[20] ?? '') == 'NO' ? '✓' : '' }}</td>
            </tr>
            <tr>
                <td>21. Used a clotting factor concentrate?</td>
                <td class="text-center">{{ ($answers[21] ?? '') == 'YES' ? '✓' : '' }}</td>
                <td class="text-center">{{ ($answers[21] ?? '') == 'NO' ? '✓' : '' }}</td>
            </tr>
            <tr>
                <td>22. Had a positive test for HIV virus, Hepatitis virus, Syphilis or Malaria?</td>
                <td class="text-center">{{ ($answers[22] ?? '') == 'YES' ? '✓' : '' }}</td>
                <td class="text-center">{{ ($answers[22] ?? '') == 'NO' ? '✓' : '' }}</td>
            </tr>
            <tr>
                <td>23. Had hepatitis?</td>
                <td class="text-center">{{ ($answers[23] ?? '') == 'YES' ? '✓' : '' }}</td>
                <td class="text-center">{{ ($answers[23] ?? '') == 'NO' ? '✓' : '' }}</td>
            </tr>
        </tbody>
    </table>

    <div class="cut-line">
        <span>✂</span>
    </div>

    <div style="font-size: 9px;">
        <strong>CONFIDENTIAL UNIT EXCLUSION (CUE):</strong><br>
        If at any point during or after your blood donation, you realized that your blood may not be safe for transfusion, please inform the Blood Service Facility staff immediately. Please use your Blood Donation ID Number and the Segment Number written below in identifying you blood donation.<br><br>
        Contact Number of Blood Service Facility: <span class="line-field" style="width: 350px;">{{ $cue->facility_contact ?? '' }}</span><br><br>
        Segment Number: <span class="line-field" style="width: 428px;">{{ $cue->segment_number ?? '' }}</span>
    </div>

    <div class="page-break"></div>

    <table class="bordered" style="margin-top: 10px;">
        <thead>
            <tr>
                <th></th>
                <th width="8%" class="text-center">YES</th>
                <th width="8%" class="text-center">NO</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>24. Had malaria?</td>
                <td class="text-center">{{ ($answers[24] ?? '') == 'YES' ? '✓' : '' }}</td>
                <td class="text-center">{{ ($answers[24] ?? '') == 'NO' ? '✓' : '' }}</td>
            </tr>
            <tr>
                <td>25. Been told to have or treated for genital wart, syphilis, gonorrhea, or other sexually transmitted infections?</td>
                <td class="text-center">{{ ($answers[25] ?? '') == 'YES' ? '✓' : '' }}</td>
                <td class="text-center">{{ ($answers[25] ?? '') == 'NO' ? '✓' : '' }}</td>
            </tr>
            <tr>
                <td>26. Had any type of cancer (e.g. Leukemia)</td>
                <td class="text-center">{{ ($answers[26] ?? '') == 'YES' ? '✓' : '' }}</td>
                <td class="text-center">{{ ($answers[26] ?? '') == 'NO' ? '✓' : '' }}</td>
            </tr>
            <tr>
                <td>27. Had any problems with your heart and lungs?</td>
                <td class="text-center">{{ ($answers[27] ?? '') == 'YES' ? '✓' : '' }}</td>
                <td class="text-center">{{ ($answers[27] ?? '') == 'NO' ? '✓' : '' }}</td>
            </tr>
            <tr>
                <td>28. Had a bleeding condition or a blood disease?</td>
                <td class="text-center">{{ ($answers[28] ?? '') == 'YES' ? '✓' : '' }}</td>
                <td class="text-center">{{ ($answers[28] ?? '') == 'NO' ? '✓' : '' }}</td>
            </tr>
            <tr>
                <td>29. Are you giving blood because you wanted to e testes for HIV or Hepatitis virus?</td>
                <td class="text-center">{{ ($answers[29] ?? '') == 'YES' ? '✓' : '' }}</td>
                <td class="text-center">{{ ($answers[29] ?? '') == 'NO' ? '✓' : '' }}</td>
            </tr>
            <tr>
                <td>30. Are you aware that if you have the HIV/Hepatitis virus, you can give it to someone else though you may feel well and have a negative HIV/Hepatitis test?</td>
                <td class="text-center">{{ ($answers[30] ?? '') == 'YES' ? '✓' : '' }}</td>
                <td class="text-center">{{ ($answers[30] ?? '') == 'NO' ? '✓' : '' }}</td>
            </tr>
        </tbody>
    </table>

    <div style="margin-top: 10px; text-align: justify; font-size: 9px; line-height: 1.3;">
        <p>“I certify that I am the person referred to in all the entries,which were read and well understood by me.it is my free and voluntary act to donate my blood,aware of its risks during and after extraction. The same have been explained to me in understandable language and dialect I speak.</p>
        <p>I am voluntarily giving my blood through <span class="line-field" style="width: 250px; text-align: center;">{{ $data['facility_name'] ?? '' }}</span>, I understand that my blood will be tested for blood type, hemoglobin, malaria, syphilis, Hepatitis B, Hepatitis C, and HIV and no official result will be released to me. If I found reactive, I agree to be referred to the appropriate facility for counselling and further management.</p>
        <p>I certify that I have to do the best of my knowledge, truthfully answered the above questions.”</p>
    </div>

    <table width="100%" style="margin-top: 15px;">
        <tr>
            <td width="55%">
                <table class="bordered" width="100%">
                    <tr>
                        <td class="font-bold" style="background: #eee;">IN CASE OF EMERGENCY</td>
                    </tr>
                    <tr>
                        <td>
                            Contact Person: <span class="line-field" style="width: 210px;">{{ $donor->emergency_person ?? '' }}</span><br>
                            Address: <span class="line-field" style="width: 245px;">{{ $donor->emergency_address ?? '' }}</span><br>
                            Contact Number: <span class="line-field" style="width: 204px;">{{ $donor->emergency_contact ?? '' }}</span>
                        </td>
                    </tr>
                </table>
            </td>
            <td width="45%" class="text-center" valign="bottom">
                <div style="border-bottom: 1px solid #000; width: 80%; margin: 0 auto;"></div>
                <div class="font-bold" style="margin-top: 3px;">Donor’s Signature</div>
            </td>
        </tr>
    </table>

    <div style="margin-top: 15px; border: 1px solid #000; padding: 5px;">
        <div class="font-bold">FOR BLOOD BANK USE ONLY</div>
        <div class="font-bold" style="margin-top: 3px;">Physical Examination</div>

        <table width="100%" style="margin-top: 5px;">
            <tr>
                <td>Body Weight: <span class="line-field" style="width: 70px;">{{ $exam->weight ?? '' }}</span></td>
                <td>Blood Pressure: <span class="line-field" style="width: 70px;">{{ $exam->bp ?? '' }}</span></td>
                <td>Pulse rate: <span class="line-field" style="width: 70px;">{{ $exam->pulse ?? '' }}</span></td>
                <td>Temperature: <span class="line-field" style="width: 70px;">{{ $exam->temp ?? '' }}</span></td>
            </tr>
            <tr>
                <td colspan="2">General Appearance: <span class="line-field" style="width: 170px;">{{ $exam->general_app ?? '' }}</span></td>
                <td colspan="2">Skin: <span class="line-field" style="width: 200px;">{{ $exam->skin ?? '' }}</span></td>
            </tr>
            <tr>
                <td colspan="2">HEENT: <span class="line-field" style="width: 218px;">{{ $exam->heent ?? '' }}</span></td>
                <td colspan="2">Heart & Lungs: <span class="line-field" style="width: 170px;">{{ $exam->heart_lungs ?? '' }}</span></td>
            </tr>
        </table>

        <div class="font-bold" style="margin-top: 8px;">Remarks:</div>
        <table width="100%">
            <tr>
                <td width="30%">
                    ( {{ ($exam->status ?? '') == 'Accepted' ? '✓' : ' ' }} ) Accepted<br>
                    ( {{ ($exam->status ?? '') == 'Temp Deferred' ? '✓' : ' ' }} ) Temporarily Deferred<br>
                    ( {{ ($exam->status ?? '') == 'Perm Deferred' ? '✓' : ' ' }} ) Permanently Deferred
                </td>
                <td width="70%" valign="top">
                    <br>
                    Reason for Deferral: <span class="line-field" style="width: 270px;">{{ $exam->deferral_reason ?? '' }}</span><br><br>
                    <span class="line-field" style="width: 370px;"></span>
                </td>
            </tr>
        </table>

        <div style="text-align: right; margin-top: 15px; margin-right: 20px;">
            <span class="line-field" style="width: 200px; text-align: center;">{{ $exam->officer_name ?? '' }}</span><br>
            <strong style="margin-right: 50px;">Blood Bank Officer</strong>
        </div>
    </div>

    <table width="100%" style="margin-top: 10px;">
        <tr>
            <td width="50%">
                Place Barcode Sticker of <strong>Donation ID</strong>
            </td>
            <td width="50%" align="right">
                <div class="barcode-box">Place Barcode Sticker Here</div>
            </td>
        </tr>
    </table>

    <table width="100%" style="margin-top: 5px;" valign="top">
        <tr>
            <td width="48%" valign="top">
                <table class="bordered" width="100%">
                    <tr class="section-header">
                        <td class="font-bold">FOR PHLEBOTOMY USE ONLY</td>
                    </tr>
                    <tr>
                        <td>
                            Blood bag: &nbsp;&nbsp;
                            <span class="checkbox-box">{{ ($phleb->bag_type ?? '') == 'Single' ? '✓' : '' }}</span> Single &nbsp;&nbsp;
                            <span class="checkbox-box">{{ ($phleb->bag_type ?? '') == 'Double' ? '✓' : '' }}</span> Double &nbsp;&nbsp;
                            <span class="checkbox-box">{{ ($phleb->bag_type ?? '') == 'Triple' ? '✓' : '' }}</span> Triple
                        </td>
                    </tr>
                    <tr><td>Segment Number: {{ $phleb->segment_number ?? '' }}</td></tr>
                    <tr><td>Time Started: {{ $phleb->time_started ?? '' }}</td></tr>
                    <tr><td>Time Finished: {{ $phleb->time_finished ?? '' }}</td></tr>
                    <tr>
                        <td style="height: 35px;" valign="bottom" class="text-center">
                            <div style="border-bottom: 1px solid #000; width: 80%; margin: 0 auto;"></div>
                            <strong>Phlebotomist</strong>
                        </td>
                    </tr>
                </table>
            </td>

            <td width="4%"></td>

            <td width="48%" valign="top">
                <table class="bordered" width="100%">
                    <thead>
                        <tr class="section-header">
                            <th colspan="2" class="text-left font-bold">FOR SCREENING USE ONLY</th>
                        </tr>
                        <tr>
                            <th width="50%" class="text-center">TEST</th>
                            <th width="50%" class="text-center">RESULT</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr><td>Blood Type</td><td>{{ $screening->blood_type ?? '' }}</td></tr>
                        <tr><td>Hemoglobin</td><td>{{ $screening->hemoglobin ?? '' }}</td></tr>
                        <tr><td>HBsAg</td><td>{{ $screening->hbsag ?? '' }}</td></tr>
                        <tr><td>RPR</td><td>{{ $screening->rpr ?? '' }}</td></tr>
                        <tr><td>HIV</td><td>{{ $screening->hiv ?? '' }}</td></tr>
                        <tr><td>HCV</td><td>{{ $screening->hcv ?? '' }}</td></tr>
                        <tr><td>Malaria</td><td>{{ $screening->malaria ?? '' }}</td></tr>
                        <tr><td>Antibody Screening</td><td>{{ $screening->antibody ?? '' }}</td></tr>
                        <tr>
                            <td colspan="2">
                                Screened by:<br>
                                <div style="border-bottom: 1px solid #000; width: 90%; margin: 10px auto 0 auto;"></div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </td>
        </tr>
    </table>

    <div class="cut-line">
        <span>✂</span>
    </div>

    <table width="100%" style="margin-top: 5px;">
        <tr>
            <td width="40%">
                Place Barcode Sticker of <strong>Donation ID</strong>
            </td>
            <td width="60%" align="left">
                <div class="barcode-box">Place Barcode Sticker Here</div>
            </td>
        </tr>
    </table>

</body>
</html>
