<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <style>
        /* Define standardized print parameters to fix the right margin clipping issue */
        @page {
            size: letter;
            margin: 0.4in 0.5in;
        }

        body {
            background: #fff;
            color: #000;
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
            font-size: 9px;
            margin: 0;
            padding: 0;
        }

        .page { position: relative; }

        /* Typography & Utilities */
        .text-8 { font-size: 8px; }
        .text-9 { font-size: 9px; }
        .text-10 { font-size: 10px; }
        .text-11 { font-size: 11px; }
        .text-xs { font-size: 11px; }
        .bold { font-weight: bold; }
        .bolder { font-weight: 800; }
        .italic { font-style: italic; }
        .uppercase { text-transform: uppercase; }
        .underline { text-decoration: underline; }
        .text-center { text-align: center; }
        .text-justify { text-align: justify; }
        .text-gray { color: #555; }
        .text-navy { color: #00008B; }
        .text-maroon { color: #8B0000; }

        /* Table and Component Line Rules */
        .border { border: 1px solid #000; }
        .border-b { border-bottom: 1px solid #000; }
        .border-t { border-top: 1px solid #000; }
        .border-2t { border-top: 2px solid #000; }
        .bg-gray { background-color: #f2f2f2; }
        .inline { display: inline-block; }
        .block { display: block; }
        .w-full { width: 100%; }

        /* Spacing utilities */
        .mt-1 { margin-top: 4px; }
        .mt-2 { margin-top: 8px; }
        .mt-3 { margin-top: 12px; }
        .mb-1 { margin-bottom: 4px; }
        .mb-2 { margin-bottom: 8px; }
        .mb-3 { margin-bottom: 12px; }
        .mb-4 { margin-bottom: 16px; }
        .ml-2 { margin-left: 8px; }
        .ml-8 { margin-left: 32px; }
        .mr-2 { margin-right: 8px; }
        .mr-4 { margin-right: 16px; }

        .px-1 { padding-left: 4px; padding-right: 4px; }
        .px-2 { padding-left: 8px; padding-right: 8px; }
        .px-4 { padding-left: 16px; padding-right: 16px; }
        .py-1 { padding-top: 4px; padding-bottom: 4px; }
        .py-2 { padding-top: 8px; padding-bottom: 8px; }
        .pl-1 { padding-left: 4px; }
        .pr-4 { padding-right: 16px; }
        .p-1 { padding: 4px; }
        .p-2 { padding: 8px; }
        .pt-2 { padding-top: 8px; }
        .pb-2 { padding-bottom: 8px; }

        .leading-snug { line-height: 1.4; }
        .leading-none { line-height: 1; }
        .indent-8 { text-indent: 32px; }
        .tracking-wide { letter-spacing: 0.5px; }

        /* Strict table structure to ensure layouts preserve right-side bounds */
        table { border-collapse: collapse; width: 100%; }
        table.auto { table-layout: auto; }
        table.fixed { table-layout: fixed; }
        td, th { vertical-align: top; padding: 0; }

        .checkbox { display: inline-block; width: 12px; height: 12px; border: 1px solid #000; vertical-align: middle; background: #fff; text-align: center; line-height: 10px; font-weight: bold; }
    </style>
</head>
<body>

<div class="page">
    <table class="mb-1" style="width: 100%;">
        <tr>
            <td style="width: 52px; vertical-align: middle;">
                <img src="{{ public_path('images/umc/institute.png') }}" alt="DLMHSI Logo" style="height:48px;width:auto; display: block;" />
            </td>
            <td style="width: 52px; vertical-align: middle; padding-left: 4px;">
                <img src="{{ public_path('images/umc/umc.png') }}" alt="DLSUMC Logo" style="height:48px;width:auto; display: block;" />
            </td>
            <td style="padding-left: 10px; vertical-align: middle;">
                <h1 class="text-11 bolder uppercase tracking-wide" style="letter-spacing:0.5px; margin: 0; line-height: 1.2;">DE LA SALLE UNIVERSITY MEDICAL CENTER</h1>
                <p class="text-8 italic" style="margin: 1px 0 2px 0;">A service of De La Salle Medical and Health Sciences Institute</p>
                <p class="text-9 bold" style="margin: 0;">Blood Bank Section</p>
                <p class="text-8" style="margin: 0; color: #333;">City of Dasmariñas, Cavite, Philippines</p>
                <p class="text-8" style="margin: 0; color: #333;">Tel no. (046) 481-8000 loc. 1197</p>
            </td>
        </tr>
    </table>

    <div class="text-center mb-2" style="border-top: 1px solid #000; border-bottom: 1px solid #000; padding: 5px 0;">
        <p class="text-9 bold" style="margin: 0 0 2px 0;">License Number: 618</p>
        <p class="text-11 bolder uppercase tracking-wide" style="margin: 0 0 2px 0;">PAUNAWA SA MGA MAGHAHANDOG NG DUGO</p>
        <p class="text-11 bolder uppercase tracking-wide" style="margin: 0;">(NOTICE TO ALL BLOOD DONORS)</p>
    </div>

    @php
        $p = $data['personal'] ?? [];

        $surname = strtoupper($p['surname'] ?? '');
        $firstName = strtoupper($p['first_name'] ?? '');
        $middleName = strtoupper($p['middle_name'] ?? '');

        $age = $p['age'] ?? '';
        $gender = $p['gender'] ?? '';
        $birthdate = !empty($p['birthdate']) ? \Carbon\Carbon::parse($p['birthdate'])->format('F d, Y') : '';
        $civilStatus = $p['civil_status'] ?? '';
        $address = $p['address'] ?? '';
        $occupation = $p['occupation'] ?? '';
        $businessAddress = $p['business_address'] ?? '';
        $cellphone = $p['cellphone'] ?? '';
        $nationality = $p['nationality'] ?? '';
        $telephone = $p['telephone'] ?? '';

        $surnameChars = str_split(str_pad($surname, max(16, mb_strlen($surname))));
        $firstNameChars = str_split(str_pad($firstName, max(16, mb_strlen($firstName))));
        $middleNameChars = str_split(str_pad($middleName, max(11, mb_strlen($middleName))));
    @endphp

    <div class="text-9 text-justify mb-2 leading-snug style-paragraphs" style="padding: 0 2px;">
        <p class="indent-8" style="margin: 0 0 4px 0;">May mga tao sa komunidad na hindi maaaring maghandog ng dugo, sa dahilang maaari silang makahawa ng impeksyon sa mga pasyenteng makatatanggap nito. Kinakailangang kumpletuhin ang mga sagot sa papeples na ito kung nais maghandog ng dugo. Kung hindi nalalaman kung paano sasagutan ang mga tanong ay maaaring kumunsulta sa kahit sinong tauhan ng DLSUMC Blood Bank.</p>
        <p class="indent-8" style="margin: 0 0 6px 0;">Ana ano mang maling pahayag o tugon sa mga sumusunod na katanungan ay labas sa batas. Kapag ito'y inyong ginawa, maaari kayong makatanggap ng mabigat na kaparusahan.</p>
        <p class="indent-8 text-gray" style="margin: 0 0 4px 0; font-style: italic;">(There are some people in the community who must not donate blood because it may transmit infections to patients who receive it. You must complete this form if you want to donate blood. If you do not know how to answer any of these questions, please check with interviewing DLSUMC Blood Bank personnel before answering the questions.</p>
        <p class="indent-8 text-gray" style="margin: 0; font-style: italic;">It is against the law to knowingly make a false or misleading statement. If you do, you may receive a heavy penalty)</p>
    </div>

    {{-- SECTION I: PERSONAL DATA --}}
    <div class="mb-2 border" style="padding: 8px; background: #fff;">
        <table class="mb-1" style="width: 100%;">
            <tr>
                <td class="bolder text-10 uppercase" style="vertical-align: middle;">I.&nbsp;&nbsp;&nbsp;PERSONAL DATA</td>
                <td style="text-align:right; vertical-align: middle; width: 200px;">
                    <span class="text-9 bold">Petsa (Date)</span>
                    <span class="border-b" style="display:inline-block;width:120px; height: 14px;">&nbsp;</span>
                </td>
            </tr>
        </table>

        <div class="text-9 bold mb-1" style="color:#00008B;">Pangalan:</div>

        <div class="mb-1">
            <table style="width:100%;">
                <tr>
                    <td style="padding-bottom: 4px;">
                        <table style="margin:0 auto;">
                            <tr>
                                @foreach ($surnameChars as $char)
                                <td style="width:19px;height:19px;border:1px solid #000;text-align:center;font-size:8px;font-weight:bold;{{ $loop->last ? '' : 'border-right:none;' }} background: #fafafa;">{{ trim($char) !== '' ? $char : '' }}</td>
                                @endforeach
                            </tr>
                        </table>
                        <div class="text-center bold text-navy text-8" style="padding-top: 2px;">APELYIDO (Surname)</div>
                    </td>
                    <td style="width:10px;"></td>
                    <td style="padding-bottom: 4px;">
                        <table style="margin:0 auto;">
                            <tr>
                                @foreach ($firstNameChars as $char)
                                <td style="width:19px;height:19px;border:1px solid #000;text-align:center;font-size:8px;font-weight:bold;{{ $loop->last ? '' : 'border-right:none;' }} background: #fafafa;">{{ trim($char) !== '' ? $char : '' }}</td>
                                @endforeach
                            </tr>
                        </table>
                        <div class="text-center bold text-navy text-8" style="padding-top: 2px;">PANGALAN (Name)</div>
                    </td>
                </tr>
                <tr>
                    <td colspan="3" style="padding-top: 2px;">
                        <table style="margin:0 auto;">
                            <tr>
                                @foreach ($middleNameChars as $char)
                                <td style="width:19px;height:19px;border:1px solid #000;text-align:center;font-size:8px;font-weight:bold;{{ $loop->last ? '' : 'border-right:none;' }} background: #fafafa;">{{ trim($char) !== '' ? $char : '' }}</td>
                                @endforeach
                            </tr>
                        </table>
                        <div class="text-center bold text-navy text-8" style="padding-top: 2px;">MIDDLE NAME</div>
                    </td>
                </tr>
            </table>
        </div>

        <table style="width: 100%;">
            <tr>
                <td style="width:52%;vertical-align:top; padding-right: 10px;">
                    <table style="width: 100%;">
                        <tr>
                            <td style="width: 50%; vertical-align: bottom;">
                                <span class="bold text-navy">Edad:</span>
                                <span class="border-b" style="display:inline-block;width:65%;padding:0 4px; text-align: center; font-weight: bold;">{{ $age }}</span>
                                <div class="text-8 text-maroon" style="margin-top: 1px;">(Age)</div>
                            </td>
                            <td style="width: 50%; vertical-align: bottom; padding-left:8px;">
                                <span class="bold text-navy">Kasarian:</span>
                                <span class="border-b" style="display:inline-block;width:55%;padding:0 4px; text-align: center; font-weight: bold;">{{ $gender }}</span>
                                <div class="text-8 text-maroon" style="margin-top: 1px;">(Sex)</div>
                            </td>
                        </tr>
                    </table>
                    <div style="margin-top:5px;">
                        <span class="bold text-navy">Petsa ng Kaarawan:</span>
                        <span class="border-b" style="display:inline-block;width:65%;padding:0 4px; font-weight: bold;">{{ $birthdate }}</span>
                        <div class="text-8 text-maroon" style="margin-top: 1px;">(Birth Date)</div>
                    </div>
                    <div style="margin-top:5px;">
                        <span class="bold text-navy">Tirahan:</span>
                        <span class="border-b" style="display:inline-block;width:82%;padding:0 4px;">{{ $address }}</span>
                        <div class="text-8 text-maroon" style="margin-top: 1px;">(Address)</div>
                    </div>
                    <div style="margin-top:5px;">
                        <span class="bold text-navy">Trabaho:</span>
                        <span class="border-b" style="display:inline-block;width:82%;padding:0 4px;">{{ $occupation }}</span>
                        <div class="text-8 text-maroon" style="margin-top: 1px;">(Occupation)</div>
                    </div>
                    <div style="margin-top:5px;">
                        <span class="bold text-navy">Lugar ng Trabaho:</span>
                        <span class="border-b" style="display:inline-block;width:70%;padding:0 4px;">{{ $businessAddress }}</span>
                        <div class="text-8 text-maroon" style="margin-top: 1px;">(Bussiness Address)</div>
                    </div>
                    <div style="margin-top:5px;">
                        <span class="bold text-navy">Pangalan ng Pasyente:</span>
                        <span class="border-b" style="display:inline-block;width:65%;">&nbsp;</span>
                        <div class="text-8 text-maroon" style="margin-top: 1px;">(Patient's Name)</div>
                    </div>
                </td>
                <td style="width:48%;vertical-align:top;padding-left:12px; border-left: 1px dashed #ccc;">
                    <div style="margin-top:2px;">
                        <span class="bold" style="margin-right: 4px;">Civil Status:</span>
                        <span style="white-space: nowrap; margin-right: 6px;">Single <span class="checkbox">{{ $civilStatus === 'Single' ? '✓' : '' }}</span></span>
                        <span style="white-space: nowrap; margin-right: 6px;">Married <span class="checkbox">{{ $civilStatus === 'Married' ? '✓' : '' }}</span></span>
                        <span style="white-space: nowrap; margin-right: 6px;">Separated <span class="checkbox">{{ $civilStatus === 'Separated' ? '✓' : '' }}</span></span>
                        <span style="white-space: nowrap;">Widow <span class="checkbox">{{ $civilStatus === 'Widow' ? '✓' : '' }}</span></span>
                    </div>
                    <div style="margin-top:10px;">
                        <span class="bold">Cellphone No.:</span>
                        <span class="border-b" style="display:inline-block;width:70%;padding:0 4px; font-weight: bold;">{{ $cellphone }}</span>
                    </div>
                    <div style="margin-top:10px;">
                        <span class="bold">Lahi:</span>
                        <span class="border-b" style="display:inline-block;width:85%;padding:0 4px;">{{ $nationality }}</span>
                        <div class="text-8 text-gray" style="margin-top: 1px;">(Nationality)</div>
                    </div>
                    <div style="margin-top:10px;">
                        <span class="bold">Telepono:</span>
                        <span class="border-b" style="display:inline-block;width:80%;padding:0 4px;">{{ $telephone }}</span>
                        <div class="text-8 text-gray" style="margin-top: 1px;">(Tel.No.)</div>
                    </div>
                </td>
            </tr>
        </table>
    </div>

    {{-- SECTION II: MEDICAL HISTORY --}}
    <div class="mt-2">
        <div class="bolder text-10 uppercase mb-1">II.&nbsp;&nbsp;&nbsp;MEDICAL HISTORY:</div>

        <div class="text-9 mb-1" style="background-color: #fff3cd; border: 1px solid #ffeeba; padding: 4px;">
            <span class="bold underline">TANDAAN</span><span>: MARKAHAN NG ( / ) <span class="bold underline">CHECK</span> ANG MGA SAGOT SA MGA TANONG NA NAAAYON SA INYO.</span>
        </div>
        <div class="text-9 bold mb-1 underline text-navy">YES / NO PLEASE CHECK APPROPRIATE ANSWER</div>

        <table class="w-full border text-9 fixed">
            <thead>
                <tr style="border-bottom: 1px solid #000;">
                    <th class="px-2 py-1" style="text-align:left; font-weight: bold;">Mga Katanungan (Questions)</th>
                    <th class="border bold" style="width:32px; text-align:center;">YES</th>
                    <th class="border bold" style="width:32px; text-align:center;">NO</th>
                </tr>
            </thead>
            <tbody>
                <tr class="bg-gray" style="border-bottom: 1px solid #000;">
                    <td colspan="3" class="px-2 py-1 bold text-navy italic">Ikaw ba ay:</td>
                </tr>
                @foreach([
                    [1, 'Nasa mabuting kalusugan ngayon?<br><span class="italic text-gray">(Feeling healthy today?)</span>'],
                    [2, 'Naggagamot o may iniinom na medikasyon?<br><span class="italic text-gray">(Currently taking medication?)</span>'],
                    [3, 'Binakunahan laban sa beke, tigdas, hepatitis o polio nitong nakaraang taon?<br><span class="italic text-gray">(Have you receive any vaccination?)</span>'],
                ] as [$num, $q])
                <tr style="border-bottom: 1px solid #ddd;">
                    <td class="px-2 py-2" style="font-weight: bold;"><span style="display:inline-block; width:15px;">{{ $num }}.</span>{!! $q !!}</td>
                    <td class="border text-center" style="background: #fff;"></td>
                    <td class="border text-center" style="background: #fff;"></td>
                </tr>
                @endforeach

                <tr class="bg-gray" style="border-top: 1px solid #000; border-bottom: 1px solid #000;">
                    <td colspan="3" class="px-2 py-1 bold text-navy italic">Tanong para sa babae:</td>
                </tr>
                @foreach([
                    [4, 'Ikaw ba ay nabuntis o buntis sa kasalukuyan o di kaya naman ay nakunan sa nakaraang 12 buwan?<br><span class="italic text-gray">(Have you been pregnant or are you pregnant now?)</span>'],
                    [5, 'Ikaw ba ay nawalan ng regla sa nakaraang anim (6) na lingo? Huling araw ng regla <span class="border-b" style="display:inline-block;width:110px;">&nbsp;</span><br><span class="italic text-gray">(Have you experience no menstruation for the past 6 months? Last menstrual period <span class="border-b" style="display:inline-block;width:110px;">&nbsp;</span>)</span>'],
                ] as [$num, $q])
                <tr style="border-bottom: 1px solid #ddd;">
                    <td class="px-2 py-2" style="font-weight: bold;"><span style="display:inline-block; width:15px;">{{ $num }}.</span>{!! $q !!}</td>
                    <td class="border text-center" style="background: #fff;"></td>
                    <td class="border text-center" style="background: #fff;"></td>
                </tr>
                @endforeach

                <tr class="bg-gray" style="border-top: 1px solid #000; border-bottom: 1px solid #000;">
                    <td colspan="3" class="px-2 py-1 bold text-navy italic">Sa Nakaraang tatlong (3) araw:</td>
                </tr>
                <tr style="border-bottom: 1px solid #ddd;">
                    <td class="px-2 py-2" style="font-weight: bold;"><span style="display:inline-block; width:15px;">6.</span>Ikaw ba ay umiinom ng Aspirin o anumang gamot na may sangkap na Aspirin?<br><span class="italic text-gray">(Have you taken any aspirin or anything that has aspirin in it?)</span></td>
                    <td class="border text-center" style="background: #fff;"></td>
                    <td class="border text-center" style="background: #fff;"></td>
                </tr>

                <tr class="bg-gray" style="border-top: 1px solid #000; border-bottom: 1px solid #000;">
                    <td colspan="3" class="px-2 py-1 bold text-navy italic">Sa nakaraang labindalawang (12) lingo o 3 buwan:</td>
                </tr>
                <tr style="border-bottom: 1px solid #ddd;">
                    <td class="px-2 py-2" style="font-weight: bold;"><span style="display:inline-block; width:15px;">7.</span>Ikaw ba ay nakapag handog na ng dugo, platelets o plasma?<br><span class="italic text-gray">(Donated blood, platelet or plasma?)</span></td>
                    <td class="border text-center" style="background: #fff;"></td>
                    <td class="border text-center" style="background: #fff;"></td>
                </tr>

                <tr class="bg-gray" style="border-top: 1px solid #000; border-bottom: 1px solid #000;">
                    <td colspan="3" class="px-2 py-1 bold text-navy italic">Sa nakaraang labindalawang (12) buwan o 1 taon:</td>
                </tr>
                @foreach([
                    [8, 'Ikaw ba ay nasalinan ng dugo?<br><span class="italic text-gray">(Had a Blood Transfusion?)</span>'],
                    [9, 'Ikaw ba ay naoperahan o nakapagpabunot ng ngipin sa dentista?<br><span class="italic text-gray">(Had surgical operation, dental extraction?)</span>'],
                    [10, 'Ikaw ba ay nagpatato, nagpabutas ng tainga, nagkaroon ng aksidenteng kontak sa dugo o aksidenteng natusok ng karayom o nagpa-acupuncture?<br><span class="italic text-gray">(Had a tattoo, ear or body piercing, accidental contact with blood, needle-stick and acupuncture?)</span>'],
                    [11, 'Ikaw ba ay nakipagtalik na o may karanasan sa pakikipagtalik sa mga sex worker (prostitute)<br><span class="italic text-gray">(Had sexual contact with high risk individuals?)</span>'],
                    [12, 'Ikaw ba ay may karanasan na sa pakikipagtalik na may kapalit na pera o anumang material na bagay?<br><span class="italic text-gray">(Had sexual contact with anyone in exchange for material or monetary gain?)</span>'],
                    [13, 'Ikaw ba ay nakipagtalik sa taong nakapag-trabaho na sa abroad?<br><span class="italic text-gray">(Had sexual contact with a person who has worked abroad?)</span>'],
                    [14, 'Ikaw ba ay nakipag-talik sa taong di mo asawa o kasalukuyang karelasyon?<br><span class="italic text-gray">(Engaged in casual sex?)</span>'],
                ] as [$num, $q])
                <tr style="border-bottom: 1px solid #ddd;">
                    <td class="px-2 py-2" style="font-weight: bold;"><span style="display:inline-block; width:15px;">{{ $num }}.</span>{!! $q !!}</td>
                    <td class="border text-center" style="background: #fff;"></td>
                    <td class="border text-center" style="background: #fff;"></td>
                </tr>
                @endforeach

                <tr class="bg-gray" style="border-top: 1px solid #000; border-bottom: 1px solid #000;">
                    <td colspan="3" class="px-2 py-1 bold text-navy italic">Naranasan mo na bang:</td>
                </tr>
                @foreach([
                    [18, 'Manirahan sa ibang lugar maliban sa kinagisnan mong bayan, probinsya o siyudad?<br><span class="italic text-gray">(Lived outside your place of residence?)</span>'],
                    [19, 'Manirahan sa ibang bansa?<br><span class="italic text-gray">(Lived outside the Philippines?)</span>'],
                    [20, 'Mag-iniksyon sa sarili ng gamot, steroids o anumang gamot na hindi inireseta ng doktor?<br><span class="italic text-gray">(Used needles to take drugs, steroids or anything not prescribed by your doctor?)</span>'],
                    [21, 'Gumamit ng "clotting factor concentrate".<br><span class="italic text-gray">(Used clotting factor concentrate?)</span>'],
                ] as [$num, $q])
                <tr style="border-bottom: 1px solid #ddd;">
                    <td class="px-2 py-2" style="font-weight: bold;"><span style="display:inline-block; width:15px;">{{ $num }}.</span>{!! $q !!}</td>
                    <td class="border text-center" style="background: #fff;"></td>
                    <td class="border text-center" style="background: #fff;"></td>
                </tr>
                @endforeach

                <tr class="bg-gray" style="border-top: 1px solid #000; border-bottom: 1px solid #000;">
                    <td colspan="3" class="px-2 py-1 bold text-navy italic">Ikaw ba ay:</td>
                </tr>
                @foreach([
                    [22, 'Nagkaroon na ng positibong pagsusuri sa AIDS?HIV, Hepatitis virus, Syphilis o Malaria?<br><span class="italic text-gray">(Had a positive test for the HIV/AIDS virus, Hepatitis virus, Syphilis or Malaria?)</span>'],
                    [23, 'Nagkaroon na ng Hepatitis?<br><span class="italic text-gray">(Had Hepatitis?)</span>'],
                    [24, 'Nagkaroon na ng Malaria?<br><span class="italic text-gray">(Had Malaria?)</span>'],
                    [25, 'Nagkaroon na at ginamot sa mga sakit na nakakahawa na nakukuha sa pamamagitan ng pakikipag-<br>talik (hal.kulugo sa maselang bahagi ng katawan, syphilis o tulo etc)<br><span class="italic text-gray">(Been told to have or treated for genital wart,syphilis, gonorrhea or other sexually transmissible infections?)</span>'],
                    [26, 'Nagkaroon na ng kahit anumang uri ng kanser (kanser sa suso, leukemia, kanser sa baga, etc)<br><span class="italic text-gray">(Had any type of cancer for example leukemia?)</span>'],
                    [27, 'Nagkaroon na ng sakit sa puso at baga?<br><span class="italic text-gray">(Had any problems with your heart and lungs?)</span>'],
                    [28, 'Nagkaroon na ng abnormal na pagdurugo sakit o impeksyon sa dugo?<br><span class="italic text-gray">(Had a bleeding condition or a blood disease?)</span>'],
                    [29, 'Ikaw ba ay naghahandog ng dugo dahil nais mo lang masuri ka sa Hepatitis virus o HIV?<br><span class="italic text-gray">(Are you giving blood because you wanted to be tested for HIV or Hepatitis virus?)</span>'],
                    [30, 'Alam mo ba na maaaring ka makasalin ng AIDS/Hepatitis mula sa iyong dugo kahit ikaw ay walang nararamdaman at negatibo sa HIV/Hepatitis.<br><span class="italic text-gray">(Know that if you have the AIDS/Hepatitis virus, you can give it to someone else though you may feel well and have a negative HIV/Hepatitis test?)</span>'],
                ] as [$num, $q])
                <tr style="border-bottom: 1px solid #ddd;">
                    <td class="px-2 py-2" style="font-weight: bold;"><span style="display:inline-block; width:15px;">{{ $num }}.</span>{!! $q !!}</td>
                    <td class="border text-center" style="background: #fff;"></td>
                    <td class="border text-center" style="background: #fff;"></td>
                </tr>
                @endforeach
            </tbody>
        </table>

        {{-- Questionnaire Continuation from Original Block structure --}}
        <table class="w-full border text-9 fixed" style="margin-top: 4px; border-top: none;">
            <tbody>
                @foreach([
                    [15, 'Ikaw ba ay may kasama sa bahay na may sakit na Hepatitis?<br><span class="italic text-gray">(Lived with a person who has hepatitis?)</span>'],
                    [16, 'Ikaw ba ay nakaranas ng makulong sa piitan?<br><span class="italic text-gray">(Have you been imprisoned?)</span>'],
                    [17, 'Mayroon ka bang kamag-anak na nagkaroon ng "Mad Cow Disease"?<br><span class="italic text-gray">(Have any of your relatives had Creutzfeldt Jakob (Mad Cow) Disease?)</span>'],
                ] as [$num, $q])
                <tr style="border-bottom: 1px solid #ddd;">
                    <td class="px-2 py-2" style="font-weight: bold;"><span style="display:inline-block; width:15px;">{{ $num }}.</span>{!! $q !!}</td>
                    <td class="border text-center" style="width:32px; background: #fff;"></td>
                    <td class="border text-center" style="width:32px; background: #fff;"></td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <div class="text-9 leading-snug text-justify mt-2" style="border: 1px solid #000; padding: 8px; background-color: #fafafa; border-radius: 4px;">
            <p class="indent-8" style="margin: 0 0 2px 0;">Ako ay kusang loob na nagbibigay ng dugo sa DLS-UMC Blood Bank upang magamit ng higit na nangangailangan. Pinahihintulutan ko sila na suriin ang aking dugo sa <b>"Blood Type, Hepatitis B, Malaria, Syphilis, HIV 1 &amp; 2, at Hepatitis C virus"</b></p>
            <p class="italic indent-8 text-gray" style="margin: 0 0 6px 0;">(I am voluntary giving blood through DLSUMC Blood Bank to be used as decided by the blood bank. I give them the permission for detailed typing of my blood and the blood screening tests for Hepatitis B, Malaria, Syphilis, HIV 1 and 2 and Hepatitis C virus.)</p>
            <p class="indent-8" style="margin: 0 0 2px 0;">Pinatutunayan ko sa abot ng aking kaalaman na pawing katotohanan ang aking isinagsot sa mga nakalahad na katanungan sa itaas at nauunawaan na ang mga pahayag ay mahalaga upang aking malaman kung ako ay nararapat na magbigay ng dugo. Ang ospital na ito at kasama ng mga tauhang bumbuo nito ay walang pananagutan sa ano mang maaaring mangyari sa pagbibigay ko ng dugo. Ako ay nangangako na hindi ako gagawa ng mabigat na trabaho sa araw ng pagbibigay ng dugo. Ako ay umaayon na ang dugo na aking inihandog ay pag-aari na ng DLSUMC Blood Bank.</p>
            <p class="italic indent-8 text-gray" style="margin: 0 0 12px 0;">(I certify that I have to the best of my knowledge, truthfully answered the above questions and understand that this information is important in determining whether I am acceptable as a blood donor. I release the hospital and its personnel from any liability that my results from this donation. I will not engage in strenuous activity on this day of donation).</p>

            <table style="margin-top: 10px; margin-left: auto; margin-right: auto; width: 260px;">
                <tr>
                    <td style="text-align: center;">
                        <div class="border-b" style="width: 100%; height: 16px;">&nbsp;</div>
                        <div class="text-9 bold text-navy" style="padding-top: 2px;">Lagda ng naghahandog ng dugo</div>
                        <div class="text-8 italic text-gray">(Signature of Donor)</div>
                    </td>
                </tr>
            </table>
        </div>

        <table style="width: 100%; margin: 4px 0 8px 0;">
            <tr>
                <td class="text-left text-8 text-gray italic">Effective July 06, 2023 | III-LABU-FR03-8</td>
            </tr>
        </table>

        {{-- SECTION III: PHYSICAL EXAMINATION --}}
        <div class="mt-2 text-9 border-t pt-2" style="background: #fff;">
            <div class="bolder text-10 uppercase mb-2 text-navy">III. PHYSICAL EXAMINATION:</div>

            <table style="width: 100%;">
                <tr>
                    <td style="width:50%;vertical-align:top; padding-right: 12px;">
                        <table style="width: 100%;">
                            <tr>
                                <td class="bold" style="white-space:nowrap; width: 45px; vertical-align: middle;">Weight:</td>
                                <td class="border-b" style="height: 16px;"></td>
                                <td class="bold" style="padding-left:16px;white-space:nowrap; width: 50px; vertical-align: middle;">Height:</td>
                                <td class="border-b" style="height: 16px;"></td>
                            </tr>
                        </table>
                        <table style="margin-top:6px; width: 100%;">
                            <tr>
                                <td class="bold" style="white-space:nowrap; width: 60px; padding-top: 4px;">Vital Signs:</td>
                                <td>
                                    <table style="width: 100%;">
                                        <tr>
                                            <td style="width: 22px; vertical-align: middle; font-weight: bold;">BP:</td>
                                            <td class="border-b" style="height:16px;">&nbsp;</td>
                                            <td style="width: 22px; padding-left:8px; vertical-align: middle; font-weight: bold;">PR:</td>
                                            <td class="border-b" style="height:16px;">&nbsp;</td>
                                        </tr>
                                        <tr>
                                            <td style="width: 22px; vertical-align: middle; font-weight: bold; padding-top: 4px;">RR:</td>
                                            <td class="border-b" style="height:16px; padding-top: 4px;">&nbsp;</td>
                                            <td style="width: 28px; padding-left:8px; vertical-align: middle; font-weight: bold; padding-top: 4px;">Temp:</td>
                                            <td class="border-b" style="height:16px; padding-top: 4px;">&nbsp;</td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                        </table>
                    </td>
                    <td style="width:50%;vertical-align:top;padding-left:12px; border-left: 1px dashed #ccc;">
                        <table style="width: 100%;">
                            <tr>
                                <td class="bold text-navy" style="width:90px; padding: 2px 0;">Tattoo:</td>
                                <td style="width: 80px;"><span class="checkbox"></span> present</td>
                                <td><span class="checkbox"></span> absent</td>
                            </tr>
                            <tr>
                                <td class="bold text-navy" style="width:90px; padding: 6px 0 2px 0;">Earpiercing:</td>
                                <td style="padding-top: 4px;"><span class="checkbox"></span> present</td>
                                <td style="padding-top: 4px;"><span class="checkbox"></span> absent</td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>

            <table class="mt-2" style="width: 100%;">
                <tr>
                    <td style="width:50%;vertical-align:top; padding-right: 12px;">
                        <table style="width: 100%;">
                            <tr><td class="bold text-navy" style="width:100px; padding: 3px 0;">SHEENT:</td><td class="border-b">&nbsp;</td></tr>
                            <tr><td class="bold text-navy" style="width:100px; padding: 3px 0;">NECK &amp; LUNGS:</td><td class="border-b">&nbsp;</td></tr>
                            <tr><td class="bold text-navy" style="width:100px; padding: 3px 0;">ABDOMEN:</td><td class="border-b">&nbsp;</td></tr>
                        </table>
                    </td>
                    <td style="width:50%;vertical-align:top;padding-left:12px;">
                        <table style="width: 100%;">
                            <tr><td class="bold text-navy" style="width:100px; padding: 3px 0;">SCLERAE:</td><td class="border-b">&nbsp;</td></tr>
                            <tr><td class="bold text-navy" style="width:100px; padding: 3px 0;">HEART:</td><td class="border-b">&nbsp;</td></tr>
                            <tr><td class="bold text-navy" style="width:100px; padding: 3px 0;">EXTREMITIES:</td><td class="border-b">&nbsp;</td></tr>
                        </table>
                    </td>
                </tr>
            </table>

            <table class="mt-2" style="width: 100%; border: 1px dashed #bbb; padding: 6px; background: #fafafa;">
                <tr>
                    <td class="bold" style="white-space:nowrap;vertical-align:top; width: 70px; padding-top: 2px;">REMARKS:</td>
                    <td>
                        <table style="width: 100%;">
                            <tr>
                                <td style="width:20px; text-align:center; vertical-align:middle;"><span class="checkbox"></span></td>
                                <td style="width: 140px; font-weight: bold; white-space:nowrap; vertical-align:middle;">Donor is physically fit:</td>
                                <td class="border-b">&nbsp;</td>
                            </tr>
                            <tr>
                                <td style="width:20px; text-align:center; vertical-align:middle; padding-top: 4px;"><span class="checkbox"></span></td>
                                <td style="font-weight: bold; vertical-align:middle; white-space:nowrap; padding-top: 4px;">Donor is unfit to donate blood. Reason:</td>
                                <td class="border-b" style="padding-top: 4px;">&nbsp;</td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>

            <table class="mt-3" style="margin-left:auto; width: auto;">
                <tr>
                    <td style="text-align:center; width: 240px;">
                        <div class="border-b" style="width:100%; height: 16px;">&nbsp;</div>
                        <div class="text-9 bold" style="padding-top: 2px;">Signature of Examiner over printed name</div>
                    </td>
                </tr>
            </table>
        </div>

        {{-- SECTION IV: INITIAL SCREENING --}}
        <div class="mt-3 text-9 border-t pt-2" style="background: #fff;">
            <table style="width: 100%;">
                <tr>
                    <td style="vertical-align:middle;">
                        <span class="bolder text-10 uppercase text-navy" style="white-space:nowrap;">IV. INITIAL SCREENING:</span>
                        <span class="bold" style="margin-left:10px;white-space:nowrap;">Hematocrit</span>
                        <span class="border-b" style="display:inline-block;width:75px; height: 14px;">&nbsp;</span>
                        <span class="bold" style="margin-left:10px;white-space:nowrap;">Hemoglobin</span>
                        <span class="border-b" style="display:inline-block;width:75px; height: 14px;">&nbsp;</span>
                        <span class="bold" style="margin-left:10px;white-space:nowrap;">BLOOD TYPE</span>
                        <span class="border-b" style="display:inline-block;width:85px; height: 14px;">&nbsp;</span>
                    </td>
                    <td style="text-align:center;white-space:nowrap;width:180px;padding-left:12px; vertical-align: middle;">
                        <div class="border-b" style="width:100%; height: 14px;">&nbsp;</div>
                        <div class="bold text-8 text-navy" style="padding-top: 2px;">MEDTECH SIGNATURE</div>
                    </td>
                </tr>
            </table>
            <div style="margin-top:4px;margin-left:24px;">
                <table style="width: 100%;">
                    <tr><td style="width:20px; text-align:center; vertical-align:middle;"><span class="checkbox"></span></td><td style="font-weight: bold; vertical-align:middle;">Donor is accepted for blood donation.</td></tr>
                    <tr><td style="width:20px; text-align:center; vertical-align:middle; padding-top: 4px;"><span class="checkbox"></span></td><td style="font-weight: bold; vertical-align:middle; white-space:nowrap; padding-top: 4px;">Donor is rejected to donate blood.&nbsp; Reason:</td><td class="border-b" style="padding-top: 4px;">&nbsp;</td></tr>
                </table>
            </div>
        </div>

        {{-- SECTION V: FINAL SCREENING --}}
        <div class="mt-3 text-9 border-t pt-2" style="background: #fff;">
            <table style="width: 100%;">
                <tr>
                    <td style="vertical-align:middle;">
                        <span class="bolder text-10 uppercase text-navy" style="white-space:nowrap;">V. FINAL SCREENING:</span>
                        <span class="bold" style="margin-left:10px;white-space:nowrap;">HBsAg</span>
                        <span class="border-b" style="display:inline-block;width:45px; height: 14px;">&nbsp;</span>
                        <span class="bold" style="margin-left:6px;white-space:nowrap;">RPR</span>
                        <span class="border-b" style="display:inline-block;width:45px; height: 14px;">&nbsp;</span>
                        <span class="bold" style="margin-left:6px;white-space:nowrap;">HCV</span>
                        <span class="border-b" style="display:inline-block;width:45px; height: 14px;">&nbsp;</span>
                        <span class="bold" style="margin-left:6px;white-space:nowrap;">HIV</span>
                        <span class="border-b" style="display:inline-block;width:45px; height: 14px;">&nbsp;</span>
                        <span class="bold" style="margin-left:6px;white-space:nowrap;">Malaria</span>
                        <span class="border-b" style="display:inline-block;width:45px; height: 14px;">&nbsp;</span>
                    </td>
                    <td style="text-align:center;white-space:nowrap;width:180px;padding-left:12px; vertical-align: middle;">
                        <div class="border-b" style="width:100%; height: 14px;">&nbsp;</div>
                        <div class="bold text-8 text-navy" style="padding-top: 2px;">MEDTECH SIGNATURE</div>
                    </td>
                </tr>
            </table>
            <div style="margin-top:4px;margin-left:24px;">
                <table style="width: 100%;">
                    <tr><td style="width:20px; text-align:center; vertical-align:middle;"><span class="checkbox"></span></td><td style="font-weight: bold; vertical-align:middle;">Donor is accepted for blood donation.</td></tr>
                    <tr><td style="width:20px; text-align:center; vertical-align:middle; padding-top: 4px;"><span class="checkbox"></span></td><td style="font-weight: bold; vertical-align:middle; white-space:nowrap; padding-top: 4px;">Donor is rejected to donate blood.&nbsp; Reason:</td><td class="border-b" style="padding-top: 4px;">&nbsp;</td></tr>
                </table>
            </div>
        </div>

        <table style="width: 100%; margin-top: 15px;">
            <tr>
                <td class="text-right text-8 text-gray italic">Effective July 06, 2023 | III-LABU-FR03-8</td>
            </tr>
        </table>
    </div>
</div>
</body>
</html>
