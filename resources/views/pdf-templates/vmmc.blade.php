<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <style>
        * { box-sizing: border-box; }
        body { background: #fff; color: #000; font-family: sans-serif; font-size: 11px; padding: 20px 24px; }
        .page { width: 100%; max-width: 950px; margin: 0 auto; padding: 0; position: relative; }
        .page-break { page-break-before: always; }
        .text-xs { font-size: 11px; }
        .text-sm { font-size: 12px; }
        .text-base { font-size: 14px; }
        .text-10 { font-size: 10px; }
        .text-9 { font-size: 9px; }
        .text-8 { font-size: 8px; }
        .bold { font-weight: bold; }
        .bolder { font-weight: 800; }
        .italic { font-style: italic; }
        .uppercase { text-transform: uppercase; }
        .underline { text-decoration: underline; }
        .text-center { text-align: center; }
        .text-left { text-align: left; }
        .text-right { text-align: right; }
        .text-justify { text-align: justify; }
        .text-red { color: #c00; }
        .border { border: 1px solid #000; }
        .border-2 { border: 2px solid #000; }
        .border-b { border-bottom: 1px solid #000; }
        .border-b2 { border-bottom: 2px solid #000; }
        .border-t { border-top: 1px solid #000; }
        .border-l { border-left: 1px solid #000; }
        .border-r { border-right: 1px solid #000; }
        .inline { display: inline-block; }
        .block { display: block; }
        .w-full { width: 100%; }
        .mt-1 { margin-top: 4px; }
        .mt-2 { margin-top: 8px; }
        .mt-3 { margin-top: 12px; }
        .mt-4 { margin-top: 16px; }
        .mb-1 { margin-bottom: 4px; }
        .mb-2 { margin-bottom: 8px; }
        .mb-3 { margin-bottom: 12px; }
        .mb-4 { margin-bottom: 16px; }
        .mb-6 { margin-bottom: 24px; }
        .ml-2 { margin-left: 8px; }
        .ml-8 { margin-left: 32px; }
        .mr-2 { margin-right: 8px; }
        .mr-4 { margin-right: 16px; }
        .px-1 { padding-left: 4px; padding-right: 4px; }
        .px-2 { padding-left: 8px; padding-right: 8px; }
        .px-4 { padding-left: 16px; padding-right: 16px; }
        .py-1 { padding-top: 4px; padding-bottom: 4px; }
        .py-2 { padding-top: 8px; padding-bottom: 8px; }
        .p-1 { padding: 4px; }
        .p-2 { padding: 8px; }
        .p-4 { padding: 16px; }
        .pt-1 { padding-top: 4px; }
        .pb-1 { padding-bottom: 4px; }
        .pl-1 { padding-left: 4px; }
        .pl-2 { padding-left: 8px; }
        .pr-1 { padding-right: 4px; }
        .pr-2 { padding-right: 8px; }
        .pr-4 { padding-right: 16px; }
        .leading-tight { line-height: 1.2; }
        .leading-snug { line-height: 1.3; }
        .indent-8 { text-indent: 32px; }
        .tracking-wide { letter-spacing: 0.5px; }
        .tracking-widest { letter-spacing: 2px; }
        .rounded-xl { border-radius: 12px; }
        table { border-collapse: collapse; width: 100%; }
        .checkbox-round { display: inline-block; width: 14px; height: 14px; border: 1px solid #000; border-radius: 50%; background: #fff; }    </style>
</head>
<body style="padding:20px 24px;">

<div class="page">
    @php
        $p = $data['personal'] ?? [];
        $h = $data['history'] ?? [];
        $sa = $data['section_a'] ?? [];
        $sb = $data['section_b'] ?? [];
        $sc = $data['section_c'] ?? [];
        $sd = $data['section_d'] ?? [];
        $se = $data['section_e'] ?? [];
        $age = !empty($p['birthdate']) ? \Carbon\Carbon::parse($p['birthdate'])->age : '';
    @endphp

    <table class="w-full border text-center text-sm leading-tight mb-2">
        <tr>
            <td rowspan="3" class="border p-1" style="width:15%;">
                <img src="{{ public_path('images/vmmc.png') }}" alt="VMMC Logo" style="width:120px;height:120px;margin:0 auto;">
            </td>
            <td class="border p-1" style="width:50%;">
                <div class="text-base bold">VETERANS MEMORIAL MEDICAL CENTER</div>
                <div>North Avenue, Diliman, Quezon City</div>
            </td>
            <td colspan="2" class="border p-1 text-left" style="width:35%;vertical-align:top;">
                <div class="text-10">Form No.:</div>
                <div class="bold text-sm">VMMC-MR-DOP_BB FORM 003</div>
            </td>
        </tr>
        <tr>
            <td class="border p-1">
                <div>DEPARTMENT OF PATHOLOGY</div>
                <div>BLOOD BANK UNIT</div>
            </td>
            <td class="border p-1 text-left" style="width:17.5%;vertical-align:top;">
                <div class="text-10">Rev. No.:</div>
                <div class="bold">01</div>
            </td>
            <td class="border p-1 text-left" style="width:17.5%;vertical-align:top;">
                <div class="text-10">Page:</div>
                <div class="bold">1 of 3</div>
            </td>
        </tr>
        <tr>
            <td class="border p-1 text-base uppercase tracking-wide">Blood Donor Interview Data Sheet</td>
            <td class="border p-1 text-left" style="vertical-align:top;">
                <div class="text-10">Issued By:</div>
                <div class="bold">DOP BB</div>
            </td>
            <td class="border p-1 text-left" style="vertical-align:top;">
                <div class="text-10">Date:</div>
                <div class="bold">October 2023</div>
            </td>
        </tr>
    </table>

    <div class="text-center mb-2">
        <div class="border rounded-xl px-4 py-1 text-center text-sm" style="display:inline-block;border:1px solid #000;border-radius:12px;padding:4px 16px;">
            Place Barcode Sticker of<br>
            Donation ID no. here
        </div>
    </div>

    <table class="mb-2">
        <tr>
            <td style="width:33%;text-align:center;vertical-align:bottom;">
                <div class="border-b" style="min-height:20px;text-align:center;font-size:12px;font-weight:bold;"></div>
                <div class="text-sm mt-1">Date</div>
            </td>
            <td style="width:33%;text-align:center;vertical-align:bottom;">
                <div class="border-b" style="min-height:20px;text-align:center;font-size:12px;font-weight:bold;"></div>
                <div class="text-sm mt-1">Serial No</div>
            </td>
            <td style="width:34%;text-align:center;vertical-align:bottom;">
                <div class="border-b" style="min-height:20px;text-align:center;font-size:12px;font-weight:bold;color:#c00;"></div>
                <div class="text-sm mt-1">Blood Type</div>
            </td>
        </tr>
    </table>

    <table class="mb-2">
        <tr>
            <td style="width:33%;text-align:center;vertical-align:bottom;">
                <div class="border-b" style="min-height:16px;text-align:center;font-size:12px;font-weight:bold;"></div>
                <div class="text-sm mt-1">Venue</div>
            </td>
            <td style="width:33%;text-align:center;vertical-align:bottom;">
                <div class="border-b" style="min-height:20px;text-align:center;font-size:12px;font-weight:bold;"></div>
                <div class="text-sm mt-1">Pilot tube</div>
            </td>
            <td style="width:34%;text-align:center;vertical-align:bottom;">
                <div class="border-b" style="min-height:20px;text-align:center;font-size:12px;font-weight:bold;"></div>
                <div class="text-sm mt-1">Type of ID/ ID no.</div>
            </td>
        </tr>
    </table>

    <div class="bold text-sm mb-1">PERSONAL DATA:</div>

    <table class="mb-1">
        <tr>
            <td style="width:33%;text-align:center;vertical-align:bottom;">
                <div class="border-b2" style="min-height:20px;text-align:center;font-size:12px;font-weight:bold;text-transform:uppercase;">{{ $p['surname'] ?? '' }}</div>
                <div class="text-xs bold mt-1">SURNAME</div>
            </td>
            <td style="width:33%;text-align:center;vertical-align:bottom;padding-left:12px;">
                <div class="border-b2" style="min-height:20px;text-align:center;font-size:12px;font-weight:bold;text-transform:uppercase;">{{ $p['given_name'] ?? '' }}</div>
                <div class="text-xs bold mt-1">GIVEN NAME</div>
            </td>
            <td style="width:34%;text-align:center;vertical-align:bottom;padding-left:12px;">
                <div class="border-b2" style="min-height:20px;text-align:center;font-size:12px;font-weight:bold;text-transform:uppercase;">{{ $p['middle_name'] ?? '' }}</div>
                <div class="text-xs bold mt-1">MIDDLE NAME</div>
            </td>
        </tr>
    </table>

    <table class="mb-2 text-sm">
        <tr>
            <td style="vertical-align:bottom;white-space:nowrap;">DATE OF BIRTH:</td>
            <td class="border-b" style="width:32px;text-align:center;min-height:20px;font-size:11px;">{{ $p['birthdate'] ?? '' }}</td>
            <td style="vertical-align:bottom;white-space:nowrap;padding-left:16px;">AGE/SEX:</td>
            <td class="border-b" style="width:32px;text-align:center;min-height:20px;font-size:11px;">{{ $age }}</td>
            <td style="text-align:center;">/</td>
            <td class="border-b" style="width:32px;text-align:center;min-height:20px;font-size:11px;">{{ $p['sex'] ?? '' }}</td>
            <td style="vertical-align:bottom;white-space:nowrap;padding-left:16px;">CIVIL STATUS:</td>
            <td class="border-b" style="text-align:center;min-height:20px;font-size:11px;">{{ $p['civil_status'] ?? '' }}</td>
            <td style="vertical-align:bottom;white-space:nowrap;padding-left:16px;">OCCUPATION:</td>
            <td class="border-b" style="text-align:center;min-height:20px;font-size:11px;">{{ $p['occupation'] ?? '' }}</td>
        </tr>
    </table>

    <table class="mb-2 text-sm">
        <tr>
            <td style="vertical-align:top;white-space:nowrap;padding-top:4px;">HOME ADDRESS:</td>
            <td>
                <table>
                    <tr>
                        <td style="vertical-align:bottom;">
                            <div class="border-b" style="min-height:20px;text-align:center;font-size:11px;">{{ $p['house_no'] ?? '' }}</div>
                            <div class="text-10 text-center mt-1">House no.</div>
                        </td>
                        <td style="vertical-align:bottom;padding-left:8px;">
                            <div class="border-b" style="min-height:20px;text-align:center;font-size:11px;">{{ $p['street'] ?? '' }}</div>
                            <div class="text-10 text-center mt-1">Street</div>
                        </td>
                        <td style="vertical-align:bottom;padding-left:8px;">
                            <div class="border-b" style="min-height:20px;text-align:center;font-size:11px;">{{ $p['subdivision'] ?? '' }}</div>
                            <div class="text-10 text-center mt-1">Subdivision</div>
                        </td>
                        <td style="vertical-align:bottom;padding-left:8px;">
                            <div class="border-b" style="min-height:20px;text-align:center;font-size:11px;">{{ $p['barangay'] ?? '' }}</div>
                            <div class="text-10 text-center mt-1">Barangay</div>
                        </td>
                        <td style="vertical-align:bottom;padding-left:8px;">
                            <div class="border-b" style="min-height:20px;text-align:center;font-size:11px;">{{ $p['city_province'] ?? '' }}</div>
                            <div class="text-10 text-center mt-1">City/Province</div>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>

    <table class="mb-2 text-sm">
        <tr>
            <td style="width:50%;vertical-align:bottom;">
                <table>
                    <tr>
                        <td style="white-space:nowrap;">EMAIL ADD.:</td>
                        <td class="border-b" style="min-height:20px;text-align:center;font-size:11px;">{{ $p['email'] ?? '' }}</td>
                    </tr>
                </table>
            </td>
            <td style="width:50%;vertical-align:bottom;padding-left:12px;">
                <table>
                    <tr>
                        <td style="white-space:nowrap;">CONTACT NUMBER:</td>
                        <td class="border-b" style="min-height:20px;text-align:center;font-size:11px;">{{ $p['contact_number'] ?? '' }}</td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>

    <table class="mb-2 text-sm">
        <tr>
            <td style="vertical-align:bottom;">
                <table>
                    <tr>
                        <td style="white-space:nowrap;">NAME OF PATIENT:</td>
                        <td class="border-b" style="min-height:20px;text-align:center;font-size:11px;"></td>
                    </tr>
                </table>
            </td>
            <td style="vertical-align:bottom;padding-left:12px;">
                <table>
                    <tr>
                        <td style="white-space:nowrap;">CATEGORY:</td>
                        <td class="border-b" style="min-height:20px;text-align:center;font-size:11px;"></td>
                    </tr>
                </table>
            </td>
            <td style="vertical-align:bottom;padding-left:12px;">
                <table>
                    <tr>
                        <td style="white-space:nowrap;">WARD/ROOM NO.:</td>
                        <td class="border-b" style="width:40px;text-align:center;min-height:20px;font-size:11px;"></td>
                        <td style="text-align:center;">/</td>
                        <td class="border-b" style="width:40px;text-align:center;min-height:20px;font-size:11px;"></td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>

    <table class="mb-1 text-sm">
        <tr>
            <td style="width:160px;white-space:nowrap;">Type of Donor:</td>
            <td style="width:145px;"><span class="checkbox-round" style="margin-right:8px;"></span>Walk-in</td>
            <td><span class="checkbox-round" style="margin-right:8px;"></span>Mobile Blood Donation</td>
        </tr>
        <tr>
            <td style="width:160px;white-space:nowrap;">Method of Collection:</td>
            <td style="width:145px;"><span class="checkbox-round" style="margin-right:8px;"></span>Conventional</td>
            <td><span class="checkbox-round" style="margin-right:8px;"></span>Apheresis</td>
        </tr>
    </table>

    <table class="w-full border-2 text-11 leading-tight mt-2">
        <thead>
            <tr>
                <th class="border p-1 text-left" style="width:85%;"></th>
                <th class="border p-1 text-center bold" style="width:7.5%;">YES<br>(OO)</th>
                <th class="border p-1 text-center bold" style="width:7.5%;">NO<br>(HINDI)</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td class="border p-1">
                    <span class="bold uppercase">MEDICAL HISTORY:</span>
                    <span class="ml-2">Check your answer <span class="italic">(Markahan ng (&#10003;) ang inyong sagot)</span></span>
                </td>
                <td class="border p-1 text-center bold"></td>
                <td class="border p-1 text-center bold"></td>
            </tr>
            <tr>
                <td class="border p-1">1. Have you donated blood before? If yes, indicate the date and place of last donation.<br><span class="italic">Nakapagbigay ka na ba ng dugo? Kung oo, isulat kung saan at kalian ang huling donasyon.</span></td>
                <td class="border p-1 text-center bold">{{ ($h['donated_before'] ?? '') === 'yes' ? '✔' : '' }}</td>
                <td class="border p-1 text-center bold">{{ ($h['donated_before'] ?? '') === 'no' ? '✔' : '' }}</td>
            </tr>
            <tr>
                <td class="border p-1">2. Have you ever donated or attempted to donate blood using different (or another) name here or elsewhere?<br><span class="italic">Nakapagbigay ka na ba ng dugo na gumamit ng ibang pangalan dito o sa ibang lugar?</span></td>
                <td class="border p-1 text-center bold">{{ ($h['used_different_name'] ?? '') === 'yes' ? '✔' : '' }}</td>
                <td class="border p-1 text-center bold">{{ ($h['used_different_name'] ?? '') === 'no' ? '✔' : '' }}</td>
            </tr>
            <tr>
                <td class="border p-1">3. Have you for any reason been deferred as a blood donor or told not to donate blood?<br><span class="italic">Ikaw ba ay hindi natanggap o nasabihan na hindi puwedeng magbigay ng dugo sa ano mang dahilan?</span></td>
                <td class="border p-1 text-center bold">{{ ($h['deferred_before'] ?? '') === 'yes' ? '✔' : '' }}</td>
                <td class="border p-1 text-center bold">{{ ($h['deferred_before'] ?? '') === 'no' ? '✔' : '' }}</td>
            </tr>
            <tr>
                <td class="border p-1 bold uppercase">SECTION A. KONDISYON SA NAKARAANG 18 NA BUWAN</td>
                <td class="border p-1 text-center bold"></td>
                <td class="border p-1 text-center bold"></td>
            </tr>
            <tr>
                <td class="border p-1">1. Have you within the last eighteen (18) months had any of the following: high blood pressure, night sweats, unexplained fevers, unexplained weight loss, persistent diarrhea, enlarged lymph node?<br><span class="italic">Sa nakaraang labing-walong (18) buwan, nagkaroon o nakaranas ka ba ng isa sa mga sumusunod: alta-presyon, pagpapawis sa gabi, hindi maipaliwanag na lagnat, madalas na pagdumi, malaking kulani?</span></td>
                <td class="border p-1 text-center bold">{{ ($sa['symptoms'] ?? '') === 'yes' ? '✔' : '' }}</td>
                <td class="border p-1 text-center bold">{{ ($sa['symptoms'] ?? '') === 'no' ? '✔' : '' }}</td>
            </tr>
            <tr>
                <td class="border p-1 bold uppercase">SECTION B. KONDISYON SA NAKARAANG 12 NA BUWAN</td>
                <td class="border p-1 text-center bold"></td>
                <td class="border p-1 text-center bold"></td>
            </tr>
            <tr>
                <td class="border p-1">1. Any of the following (ENCIRCLE): malaria, hepatitis, jaundice, syphilis, chicken pox, shingles, cold sores, serious accident, cancer, blood disease like leukemia, recent or severe respiratory disease, cardiovascular disease, kidney disease, syphilis, diabetes, asthma, epilepsy, tuberculosis?<br><span class="italic">Nagkaroon o nakaranas sa mga sumusunod: malarya, sakit sa atay, paninilaw ng mga mata at buong katawan, tulo, bulutong tubig, singaw, malubhang aksidente, kanser, sakit sa dugo tulad ng leukemia o walang tigil na pagdurugo, sakit sa baga, sakit sa puso, sakit sa bato, syphilis, dyabetis, hika, epilepsy, tuberculosis?</span></td>
                <td class="border p-1 text-center bold">{{ ($sb['diseases'] ?? '') === 'yes' ? '✔' : '' }}</td>
                <td class="border p-1 text-center bold">{{ ($sb['diseases'] ?? '') === 'no' ? '✔' : '' }}</td>
            </tr>
            <tr>
                <td class="border p-1">2. Under doctor's care or had a major illness or surgery?<br><span class="italic">Nasa pangangalaga ng doctor o nagkaroon ng malubhang karamdaman o operasyon?</span></td>
                <td class="border p-1 text-center bold">{{ ($sb['doctor_care'] ?? '') === 'yes' ? '✔' : '' }}</td>
                <td class="border p-1 text-center bold">{{ ($sb['doctor_care'] ?? '') === 'no' ? '✔' : '' }}</td>
            </tr>
            <tr>
                <td class="border p-1">3. Have you ever had a dental surgery for the past twelve (12) months or tooth extraction for the past six (6) months?<br><span class="italic">Naoperahan ka ba ng ngipin sa nakaraang labindalawang (12) buwan? O Nagpabunot ka ba ng ngipin simula nitong nakaraang anim (6) na buwan?</span></td>
                <td class="border p-1 text-center bold">{{ ($sb['dental'] ?? '') === 'yes' ? '✔' : '' }}</td>
                <td class="border p-1 text-center bold">{{ ($sb['dental'] ?? '') === 'no' ? '✔' : '' }}</td>
            </tr>
            <tr>
                <td class="border p-1">4. Taken prohibited drugs? (orally, by nose or injection)<br><span class="italic">Nakagamit ng mga ipinagbabawal na gamut? (ininum, sininghot "cocaine" o naitusok ng karayom)</span></td>
                <td class="border p-1 text-center bold">{{ ($sb['drugs'] ?? '') === 'yes' ? '✔' : '' }}</td>
                <td class="border p-1 text-center bold">{{ ($sb['drugs'] ?? '') === 'no' ? '✔' : '' }}</td>
            </tr>
            <tr>
                <td class="border p-1">5. Received blood or taken clotting factor concentrates for bleeding problem such as hemophilia and had an organ or tissue transplant or graft?<br><span class="italic">Ikaw ba ay nasalinan ng dugo dahil sa hemophilia at naoperahan o nabigyan ng bahagi ng katawan na galing sa ibang tao?</span></td>
                <td class="border p-1 text-center bold">{{ ($sb['transplant'] ?? '') === 'yes' ? '✔' : '' }}</td>
                <td class="border p-1 text-center bold">{{ ($sb['transplant'] ?? '') === 'no' ? '✔' : '' }}</td>
            </tr>
        </tbody>
    </table>
</div>

<div class="page-break"></div>

<div class="page">
    <table class="w-full border-2 text-11 leading-tight">
        <thead>
            <tr>
                <th class="border p-1 text-left" style="width:85%;"></th>
                <th class="border p-1 text-center bold" style="width:7.5%;">YES<br>(OO)</th>
                <th class="border p-1 text-center bold" style="width:7.5%;">NO<br>(HINDI)</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td class="border p-1">6. A tattoo applied, ear piercing, acupuncture, accidental needle stick or come in contact with someone else's blood?<br><span class="italic">Nagpalagay ng tattoo, nagpabutas sa tenga, nagpa-akyupuncture, naturukan ng karayom nang hindi sinasadya o nadikit sa dugo ng ibang tao?</span></td>
                <td class="border p-1 text-center bold">{{ ($sb['tattoo'] ?? '') === 'yes' ? '✔' : '' }}</td>
                <td class="border p-1 text-center bold">{{ ($sb['tattoo'] ?? '') === 'no' ? '✔' : '' }}</td>
            </tr>
            <tr>
                <td class="border p-1">7. Engaged in sexual activity on the same sex or multiple sexual partners?<br><span class="italic">Nagkaroon ng karanasan na makipagtalik sa kaparehong kasarian (lalaki sa lalaki, babae sa babae) o higit pa sa isa ang naging katalik</span></td>
                <td class="border p-1 text-center bold">{{ ($sb['sex_multi'] ?? '') === 'yes' ? '✔' : '' }}</td>
                <td class="border p-1 text-center bold">{{ ($sb['sex_multi'] ?? '') === 'no' ? '✔' : '' }}</td>
            </tr>
            <tr>
                <td class="border p-1">8. Engaged in sexual activity with an individual who received an injection without proper medical supervision?<br><span class="italic">Nagkaroon ng karanasan sa taong naturukan ng gamot na walang pahintulot ng doktor?</span></td>
                <td class="border p-1 text-center bold">{{ ($sb['sex_unsupervised'] ?? '') === 'yes' ? '✔' : '' }}</td>
                <td class="border p-1 text-center bold">{{ ($sb['sex_unsupervised'] ?? '') === 'no' ? '✔' : '' }}</td>
            </tr>
            <tr>
                <td class="border p-1">9. In personal contact with anyone who had hepatitis?<br><span class="italic">May nakasama sa bahay o taong lagi mong nakakahalubilo na may sakit sa atay?</span></td>
                <td class="border p-1 text-center bold"></td>
                <td class="border p-1 text-center bold"></td>
            </tr>
            <tr>
                <td class="border p-1">10. Given money or drugs to anyone to have sex with you or had sex with anyone who has taken money or drugs for sex?<br><span class="italic">Nagbayad kahit kanino para lang makipagtalik sa iyo o nakipagtalik kahit kanino na tumatanggap ng pera o ng ipinagbabawal na gamot para lang makipag talik sa isang tao?</span></td>
                <td class="border p-1 text-center bold">{{ ($sb['sex_money'] ?? '') === 'yes' ? '✔' : '' }}</td>
                <td class="border p-1 text-center bold">{{ ($sb['sex_money'] ?? '') === 'no' ? '✔' : '' }}</td>
            </tr>
            <tr>
                <td class="border p-1">11. A sexual partner who is bisexual or medically unsupervised user of intravenous drug, who had taken clotting factor concentrates for bleeding problem and has HIV or had a positive test for HIV virus?<br><span class="italic">Nagkaroon ka ba ng kasintahan na nakikipagtalik sa kaparehong kasarian at gumagamit ng gamot na walang pahintulot ng doktor?</span></td>
                <td class="border p-1 text-center bold">{{ ($sb['sex_bisexual'] ?? '') === 'yes' ? '✔' : '' }}</td>
                <td class="border p-1 text-center bold">{{ ($sb['sex_bisexual'] ?? '') === 'no' ? '✔' : '' }}</td>
            </tr>
            <tr>
                <td class="border p-1">12. To malaria endemic areas like Palawan and Mindoro?<br><span class="italic">Nakapunta sa lugar na laganap ang malaria katulad ng Palawan at Mindoro?</span></td>
                <td class="border p-1 text-center bold">{{ ($sb['malaria_area'] ?? '') === 'yes' ? '✔' : '' }}</td>
                <td class="border p-1 text-center bold">{{ ($sb['malaria_area'] ?? '') === 'no' ? '✔' : '' }}</td>
            </tr>
            <tr>
                <td class="border p-1">13. In jail or prison?<br><span class="italic">Nakulong o nabilanggo?</span></td>
                <td class="border p-1 text-center bold">{{ ($sb['jail'] ?? '') === 'yes' ? '✔' : '' }}</td>
                <td class="border p-1 text-center bold">{{ ($sb['jail'] ?? '') === 'no' ? '✔' : '' }}</td>
            </tr>

            <tr>
                <td class="border p-1 bold uppercase">SECTION C. KONDISYON SA NAKARAANG 4 NA LINGGO</td>
                <td class="border p-1 text-center bold"></td>
                <td class="border p-1 text-center bold"></td>
            </tr>
            <tr>
                <td class="border p-1">1. In the past four weeks, have you taken any medications such as Isotretinoin (Accutane) or Finasteride (Proscar, Propecia), etretinate (Tegison) for psoriasis, Feldene, aspirin other medicines?<br><span class="italic">Sa nakaraang apat na lingo, ikaw ba ay nakainom ng as Isotretinoin (Accutane) or Finasteride (Proscar, Propecia), Etretinate (Tegison) para sa psoriasis, Feldene, aspirin o kahit anong gamot?</span></td>
                <td class="border p-1 text-center bold">{{ ($sc['meds'] ?? '') === 'yes' ? '✔' : '' }}</td>
                <td class="border p-1 text-center bold">{{ ($sc['meds'] ?? '') === 'no' ? '✔' : '' }}</td>
            </tr>
            <tr>
                <td class="border p-1">2. Have you ever received human pituitary-derived growth hormone or had a brain covering graft?<br><span class="italic">Ikaw ba ay tumanggap ng "human pituitary-derived growth hormone" o naoperahan na sa uttak?</span></td>
                <td class="border p-1 text-center bold">{{ ($sc['growth_hormone'] ?? '') === 'yes' ? '✔' : '' }}</td>
                <td class="border p-1 text-center bold">{{ ($sc['growth_hormone'] ?? '') === 'no' ? '✔' : '' }}</td>
            </tr>
            <tr>
                <td class="border p-1">3. Have you within the last twenty-four (24) hours had an intake of alcohol?<br><span class="italic">Nakainom ka ba ng alak sa nakaraang dalawampu't apat (24) na oras</span></td>
                <td class="border p-1 text-center bold">{{ ($sc['alcohol'] ?? '') === 'yes' ? '✔' : '' }}</td>
                <td class="border p-1 text-center bold">{{ ($sc['alcohol'] ?? '') === 'no' ? '✔' : '' }}</td>
            </tr>
            <tr>
                <td class="border p-1">4. Do you intend to ride/pilot an airplane within twenty-four (24) hours or tend to drive a heavy or any transport vehicle within the next twelve (12) hours?<br><span class="italic">Ikaw ba ay may balak na sumakay/magpalipad ng eroplano sa susunod na dalawangpu't apat na oras o may balak na magmaneho ng sasakyan sa susunod na labindalawang oras?</span></td>
                <td class="border p-1 text-center bold">{{ ($sc['pilot_driver'] ?? '') === 'yes' ? '✔' : '' }}</td>
                <td class="border p-1 text-center bold">{{ ($sc['pilot_driver'] ?? '') === 'no' ? '✔' : '' }}</td>
            </tr>
            <tr>
                <td class="border p-1">5. Are you currently suffering from illness, allergy, or any infectious disease?<br><span class="italic">Sa kasalukuyan, ikaw ba ay may karamdaman, nakahahawang sakit tulad ng sipon, nakararanas ng pangangati (allergy), trangkaso, o pananakit ng lalamunan?</span></td>
                <td class="border p-1 text-center bold">{{ ($sc['illness'] ?? '') === 'yes' ? '✔' : '' }}</td>
                <td class="border p-1 text-center bold">{{ ($sc['illness'] ?? '') === 'no' ? '✔' : '' }}</td>
            </tr>

            <tr>
                <td class="border p-1 bold uppercase">SECTION D. COVID-19</td>
                <td class="border p-1 text-center bold"></td>
                <td class="border p-1 text-center bold"></td>
            </tr>
            <tr>
                <td class="border p-1">1. In the past 28 days, have you travelled outside the Philippines? If yes, indicate the country/ies.<br><span class="italic">Sa nakalipas na dalawangpu't walong araw, ikaw ba ay nag biyahe sa labas ng Pilipinas? Kung Oo, isaad kung anung bansa o mga bansa.</span></td>
                <td class="border p-1 text-center bold">{{ ($sd['travel_intl'] ?? '') === 'yes' ? '✔' : '' }}</td>
                <td class="border p-1 text-center bold">{{ ($sd['travel_intl'] ?? '') === 'no' ? '✔' : '' }}</td>
            </tr>
            <tr>
                <td class="border p-1">2. In the past 28 days, have you ever had close contact (live with, worked with, travelled with or cared for) a confirmed COVID-19 patient<br><span class="italic">Sa nakalipas na dalawangpu't walong araw, ikaw ba ay may nakasalamuha (kasama sa bahay, katrabaho, nakasabay sa biyahe) na isang COVID-19 patient?</span></td>
                <td class="border p-1 text-center bold">{{ ($sd['covid_contact'] ?? '') === 'yes' ? '✔' : '' }}</td>
                <td class="border p-1 text-center bold">{{ ($sd['covid_contact'] ?? '') === 'no' ? '✔' : '' }}</td>
            </tr>
            <tr>
                <td class="border p-1">3. Have you ever had close contact with a person exhibiting symptoms of acute respiratory illness?<br><span class="italic">May nakasalamuha na may sintomas ng ubo, sipon, lagnat o acute respiratory illness?</span></td>
                <td class="border p-1 text-center bold">{{ ($sd['symptoms_contact'] ?? '') === 'yes' ? '✔' : '' }}</td>
                <td class="border p-1 text-center bold">{{ ($sd['symptoms_contact'] ?? '') === 'no' ? '✔' : '' }}</td>
            </tr>
            <tr>
                <td class="border p-1">4. Have you received vaccine against COVID-19? If Yes, kindly indicate the date and type of vaccine. _____________________<br><span class="italic">Ikaw ba ay nakatanggap na ng bakuna laban sa COVID-19? Kung Oo, Kailan at anong bakuna ito.____________________________</span></td>
                <td class="border p-1 text-center bold">{{ ($sd['vaccine_received'] ?? '') === 'yes' ? '✔' : '' }}</td>
                <td class="border p-1 text-center bold">{{ ($sd['vaccine_received'] ?? '') === 'no' ? '✔' : '' }}</td>
            </tr>

            <tr>
                <td class="border p-1 bold uppercase">SECTION E. FEMALE DONORS (PARA SA MGA KABABAIHAN)</td>
                <td class="border p-1 text-center bold"></td>
                <td class="border p-1 text-center bold"></td>
            </tr>
            <tr>
                <td class="border p-1">
                    1. When was your last delivery? {{ $se['delivery'] ?? '_________' }} When was your last menstruation? {{ $se['menstruation'] ?? '_________' }}<br>
                    <span class="italic">Kailan ka huling nanganak? {{ $se['delivery'] ?? '____________' }} Kailan ka huling dinatnan/niregla? {{ $se['menstruation'] ?? '' }}</span>
                </td>
                <td class="border p-1 text-center bold"></td>
                <td class="border p-1 text-center bold"></td>
            </tr>
        </tbody>
    </table>
</div>

<div class="page-break"></div>

<div class="page">
    <div class="bold text-sm mb-1">CONSENT</div>

    <div class="text-xs leading-snug mb-2" style="line-height:1.3;">
        <p class="indent-8">"I have read this form and understand its content and voluntarily give my consent for the collection, use, processing, storage and retention of my personal data or information to OPERATION LIFELINE - VMMC for the purpose described in this document. I also understand that my consent does not prevent the existence of other criteria for lawful processing of personal data and does not waive any of my rights under RA 10173- Data Privacy Act of 2012 and other applicable laws.</p>
        <p class="indent-8">It is my free and voluntary act and deed to donate my blood and I am aware of its risks and consequences during and after extraction having been explained to me in clear and understandable language and dialect that I speak."</p>
        <p class="indent-8">I understand that my blood will be screened for blood type, hemoglobin, malaria, syphilis, hepatitis B & C, and HIV 1 & 2 and no result will be issued to me. If found reactive, I agree to be referred to the appropriate facility for counseling and further management. I certify that I have to the best of my knowledge, truthfully answered the above questions."</p>
        <p class="indent-8 italic">"Nagpapatunay na ako ang taong tinutukoy at ang lahat ng nakasulat dito ay nabasa ko at naiintindihan at ako ay kusang loob na magbibigay ng dugo. Alam ko ang mga panganib at kahihinatnan sa mga sandaling kinukuhanan ako ng dugo hanggang sa matapos ang donasyon. Ito ay naipaliwanag sa akin at naiintindihan ko nang mabuti."</p>
        <p class="indent-8 italic">"Pagkatapos masagutan nang buong katapatan ang mga tanong, ako ay kusa at buong loob na magbibigay ng dugo sa OPERATION LIFELINE - VMMC. Naiintindihan ko na ang aking dugo ay susurin nang mabuti upang malaman ang blood type, hemoglobin, malaria, syphilis, hepatitis B at C, at HIV 1 at 2 at walang opisyal na resulta na ibibgay sa akin. Kung sakaling maging "reactive", ako ay sumasang-ayon na maisangguni sa nararapat na pasilidad para sa karagdagang pagsusuri.</p>
    </div>

    <div style="width:60%;margin:0 auto 12px auto;">
        <div class="border-b" style="min-height:20px;"></div>
        <div class="text-xs bold mt-1 text-center">(Donor's Signature/ Lagda ng magbibigay donasyon)</div>
    </div>

    <div class="text-center bold text-base underline mb-2">FOR BLOOD BANK USE ONLY</div>

    <div class="bold text-sm underline mb-2">PHYSICAL EXAMINATION:</div>

    <table class="mb-2 text-xs">
        <tr>
            <td style="vertical-align:bottom;"><span style="white-space:nowrap;">Body Weight:</span><span class="border-b" style="display:inline-block;width:80px;">&nbsp;</span></td>
            <td style="vertical-align:bottom;padding-left:8px;"><span style="white-space:nowrap;">Blood Pressure:</span><span class="border-b" style="display:inline-block;width:80px;">&nbsp;</span></td>
            <td style="vertical-align:bottom;padding-left:8px;"><span style="white-space:nowrap;">Pulse Rate:</span><span class="border-b" style="display:inline-block;width:80px;">&nbsp;</span></td>
            <td style="vertical-align:bottom;padding-left:8px;"><span style="white-space:nowrap;">Temperature:</span><span class="border-b" style="display:inline-block;width:80px;">&nbsp;</span></td>
        </tr>
    </table>

    <table class="mb-2 text-xs">
        <tr>
            <td style="vertical-align:bottom;"><span style="white-space:nowrap;">General Appearance:</span><span class="border-b" style="display:inline-block;width:120px;">&nbsp;</span></td>
            <td style="vertical-align:bottom;padding-left:16px;"><span style="white-space:nowrap;">Skin:</span><span class="border-b" style="display:inline-block;width:180px;">&nbsp;</span></td>
        </tr>
    </table>

    <table class="mb-2 text-xs">
        <tr>
            <td style="vertical-align:bottom;"><span style="white-space:nowrap;">HEENT:</span><span class="border-b" style="display:inline-block;width:120px;">&nbsp;</span></td>
            <td style="vertical-align:bottom;padding-left:16px;"><span style="white-space:nowrap;">Heart and Lungs:</span><span class="border-b" style="display:inline-block;width:180px;">&nbsp;</span></td>
        </tr>
    </table>

    <div class="text-xs mb-3">
        <div class="mb-2">REMARKS:</div>
        <table style="margin-left:32px;">
            <tr><td style="width:16px;" class="text-10">O</td><td>Accepted</td></tr>
            <tr><td class="text-10">O</td><td>Temporarily Deferred</td></tr>
            <tr><td class="text-10">O</td><td>Permanently Deferred</td></tr>
        </table>
        <table style="margin-left:32px;margin-top:8px;">
            <tr><td style="white-space:nowrap;">Reason:</td><td class="border-b" style="min-height:16px;">&nbsp;</td></tr>
        </table>
    </div>

    <table class="text-xs">
        <tr>
            <td style="width:40%;vertical-align:top;">
                <table style="margin-top:16px;">
                    <tr><td style="width:95px;">Hemoglobin:</td><td class="border-b" style="min-height:16px;">&nbsp;</td></tr>
                    <tr><td style="width:95px;">Hematocrit:</td><td class="border-b" style="min-height:16px;">&nbsp;</td></tr>
                    <tr><td style="width:95px;">Malaria :</td><td class="border-b" style="min-height:16px;">&nbsp;</td></tr>
                    <tr><td style="width:95px;">Platelet Count:</td><td class="border-b" style="min-height:16px;">&nbsp;</td></tr>
                    <tr><td style="width:95px;">WBC Count:</td><td class="border-b" style="min-height:16px;">&nbsp;</td></tr>
                </table>
            </td>
            <td style="width:40%;padding-left:16px;vertical-align:top;">
                <div class="border-b" style="min-height:16px;"></div>
                <span class="mt-1">Examining Physician/Nurse</span>
                <span class="text-10">(Signature over printed name)</span>

                <div style="margin-top:24px;">
                    <span>Screened by:</span>
                    <div class="border-b" style="min-height:16px;"></div>
                    <div class="border-b" style="min-height:16px;"></div>
                    <div class="border-b" style="min-height:16px;"></div>
                    <div class="border-b" style="min-height:16px;"></div>
                </div>
            </td>
        </tr>
    </table>

    <table class="text-xs" style="margin-top:4px;">
        <tr>
            <td style="width:50%;vertical-align:top;padding-right:16px;">
                <div style="margin-top:8px;">
                    <div class="border-b" style="width:190px;min-height:14px;"></div>
                    <span>PHLEBOTOMIST (print name & sign)</span>
                </div>
                <table style="margin-top:4px;">
                    <tr><td style="width:80px;">Time Started:</td><td class="border-b" style="width:95px;min-height:14px;">&nbsp;</td></tr>
                    <tr><td style="width:80px;">Time Finished:</td><td class="border-b" style="width:95px;min-height:14px;">&nbsp;</td></tr>
                </table>
            </td>
            <td style="width:50%;vertical-align:top;">
                <div style="height:16px;">Remarks:</div>
                <table>
                    <tr>
                        <td style="width:110px;">Sufficient Collection:</td>
                        <td style="letter-spacing:2px;">( )</td>
                        <td class="border-b" style="width:80px;min-height:14px;">&nbsp;</td>
                        <td>mL</td>
                    </tr>
                    <tr>
                        <td style="width:110px;">Insufficient Collection:</td>
                        <td style="letter-spacing:2px;">( )</td>
                        <td class="border-b" style="width:80px;min-height:14px;">&nbsp;</td>
                        <td>mL</td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>

    <table class="mt-2 text-xs">
        <tr>
            <td style="white-space:nowrap;">Blood Bag Used:</td>
            <td style="padding-left:8px;"><span style="letter-spacing:2px;">( )</span> Single Bag</td>
            <td style="padding-left:8px;"><span style="letter-spacing:2px;">( )</span> Double Bag</td>
            <td style="padding-left:8px;"><span style="letter-spacing:2px;">( )</span> Triple Bag</td>
        </tr>
    </table>
</div>
</body>
</html>
