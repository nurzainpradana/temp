<?php
	require_once 'php/faker/autoload.php';
	$faker = Faker\Factory::create();

    $admin_version = 'v1.4';

    function dateRange( $first, $last, $step = '+1 day', $format = 'D d.m.Y' ) {

        $dates = array();
        $current = strtotime( $first );
        $last = strtotime( $last );

        while( $current <= $last ) {

            $dates[] = date( $format, $current );
            $current = strtotime( $step, $current );
        }

        return $dates;
    }

    $tags = array( 'advertising', 'ajax', 'business', 'company', 'creative', 'css', 'design', 'designer', 'developer', 'e-commerce', 'finance', 'graphic', 'home', 'internet', 'javascript', 'marketing', 'mysql', 'online', 'photoshop', 'service', 'software', 'webdesign', 'website' );

    $countries = array("AF" => "Afghanistan (‫افغانستان‬‎)", "AX" => "Åland Islands (Åland)", "AL" => "Albania (Shqipëri)", "DZ" => "Algeria (‫الجزائر‬‎)", "AS" => "American Samoa", "AD" => "Andorra", "AO" => "Angola", "AI" => "Anguilla", "AQ" => "Antarctica", "AG" => "Antigua and Barbuda", "AR" => "Argentina", "AM" => "Armenia (Հայաստան)", "AW" => "Aruba", "AC" => "Ascension Island", "AU" => "Australia", "AT" => "Austria (Österreich)", "AZ" => "Azerbaijan (Azərbaycan)", "BS" => "Bahamas", "BH" => "Bahrain (‫البحرين‬‎)", "BD" => "Bangladesh (বাংলাদেশ)", "BB" => "Barbados", "BY" => "Belarus (Беларусь)", "BE" => "Belgium (België)", "BZ" => "Belize", "BJ" => "Benin (Bénin)", "BM" => "Bermuda", "BT" => "Bhutan (འབྲུག)", "BO" => "Bolivia", "BA" => "Bosnia and Herzegovina (Босна и Херцеговина)", "BW" => "Botswana", "BV" => "Bouvet Island", "BR" => "Brazil (Brasil)", "IO" => "British Indian Ocean Territory", "VG" => "British Virgin Islands", "BN" => "Brunei", "BG" => "Bulgaria (България)", "BF" => "Burkina Faso", "BI" => "Burundi (Uburundi)", "KH" => "Cambodia (កម្ពុជា)", "CM" => "Cameroon (Cameroun)", "CA" => "Canada", "IC" => "Canary Islands (islas Canarias)", "CV" => "Cape Verde (Kabu Verdi)", "BQ" => "Caribbean Netherlands", "KY" => "Cayman Islands", "CF" => "Central African Republic (République centrafricaine)", "EA" => "Ceuta and Melilla (Ceuta y Melilla)", "TD" => "Chad (Tchad)", "CL" => "Chile", "CN" => "China (中国)", "CX" => "Christmas Island", "CP" => "Clipperton Island", "CC" => "Cocos (Keeling) Islands (Kepulauan Cocos (Keeling))", "CO" => "Colombia", "KM" => "Comoros (‫جزر القمر‬‎)", "CD" => "Congo (DRC) (Jamhuri ya Kidemokrasia ya Kongo)", "CG" => "Congo (Republic) (Congo-Brazzaville)", "CK" => "Cook Islands", "CR" => "Costa Rica", "CI" => "Côte d’Ivoire", "HR" => "Croatia (Hrvatska)", "CU" => "Cuba", "CW" => "Curaçao", "CY" => "Cyprus (Κύπρος)", "CZ" => "Czech Republic (Česká republika)", "DK" => "Denmark (Danmark)", "DG" => "Diego Garcia", "DJ" => "Djibouti", "DM" => "Dominica", "DO" => "Dominican Republic (República Dominicana)", "EC" => "Ecuador", "EG" => "Egypt (‫مصر‬‎)", "SV" => "El Salvador", "GQ" => "Equatorial Guinea (Guinea Ecuatorial)", "ER" => "Eritrea", "EE" => "Estonia (Eesti)", "ET" => "Ethiopia", "FK" => "Falkland Islands (Islas Malvinas)", "FO" => "Faroe Islands (Føroyar)", "FJ" => "Fiji", "FI" => "Finland (Suomi)", "FR" => "France", "GF" => "French Guiana (Guyane française)", "PF" => "French Polynesia (Polynésie française)", "TF" => "French Southern Territories (Terres australes françaises)", "GA" => "Gabon", "GM" => "Gambia", "GE" => "Georgia (საქართველო)", "DE" => "Germany (Deutschland)", "GH" => "Ghana (Gaana)", "GI" => "Gibraltar", "GR" => "Greece (Ελλάδα)", "GL" => "Greenland (Kalaallit Nunaat)", "GD" => "Grenada", "GP" => "Guadeloupe", "GU" => "Guam", "GT" => "Guatemala", "GG" => "Guernsey", "GN" => "Guinea (Guinée)", "GW" => "Guinea-Bissau (Guiné Bissau)", "GY" => "Guyana", "HT" => "Haiti", "HM" => "Heard & McDonald Islands", "HN" => "Honduras", "HK" => "Hong Kong (香港)", "HU" => "Hungary (Magyarország)", "IS" => "Iceland (Ísland)", "IN" => "India (भारत)", "ID" => "Indonesia", "IR" => "Iran (‫ایران‬‎)", "IQ" => "Iraq (‫العراق‬‎)", "IE" => "Ireland", "IM" => "Isle of Man", "IL" => "Israel (‫ישראל‬‎)", "IT" => "Italy (Italia)", "JM" => "Jamaica", "JP" => "Japan (日本)", "JE" => "Jersey", "JO" => "Jordan (‫الأردن‬‎)", "KZ" => "Kazakhstan (Казахстан)", "KE" => "Kenya", "KI" => "Kiribati", "XK" => "Kosovo (Kosovë)", "KW" => "Kuwait (‫الكويت‬‎)", "KG" => "Kyrgyzstan (Кыргызстан)", "LA" => "Laos (ລາວ)", "LV" => "Latvia (Latvija)", "LB" => "Lebanon (‫لبنان‬‎)", "LS" => "Lesotho", "LR" => "Liberia", "LY" => "Libya (‫ليبيا‬‎)", "LI" => "Liechtenstein", "LT" => "Lithuania (Lietuva)", "LU" => "Luxembourg", "MO" => "Macau (澳門)", "MK" => "Macedonia (FYROM) (Македонија)", "MG" => "Madagascar (Madagasikara)", "MW" => "Malawi", "MY" => "Malaysia", "MV" => "Maldives", "ML" => "Mali", "MT" => "Malta", "MH" => "Marshall Islands", "MQ" => "Martinique", "MR" => "Mauritania (‫موريتانيا‬‎)", "MU" => "Mauritius (Moris)", "YT" => "Mayotte", "MX" => "Mexico (México)", "FM" => "Micronesia", "MD" => "Moldova (Republica Moldova)", "MC" => "Monaco", "MN" => "Mongolia (Монгол)", "ME" => "Montenegro (Crna Gora)", "MS" => "Montserrat", "MA" => "Morocco (‫المغرب‬‎)", "MZ" => "Mozambique (Moçambique)", "MM" => "Myanmar (Burma)", "NA" => "Namibia (Namibië)", "NR" => "Nauru", "NP" => "Nepal (नेपाल)", "NL" => "Netherlands (Nederland)", "NC" => "New Caledonia (Nouvelle-Calédonie)", "NZ" => "New Zealand", "NI" => "Nicaragua", "NE" => "Niger (Nijar)", "NG" => "Nigeria", "NU" => "Niue", "NF" => "Norfolk Island", "MP" => "Northern Mariana Islands", "KP" => "North Korea (조선 민주주의 인민 공화국)", "NO" => "Norway (Norge)", "OM" => "Oman (‫عُمان‬‎)", "PK" => "Pakistan (‫پاکستان‬‎)", "PW" => "Palau", "PS" => "Palestine (‫فلسطين‬‎)", "PA" => "Panama (Panamá)", "PG" => "Papua New Guinea", "PY" => "Paraguay", "PE" => "Peru (Perú)", "PH" => "Philippines", "PN" => "Pitcairn Islands", "PL" => "Poland (Polska)", "PT" => "Portugal", "PR" => "Puerto Rico", "QA" => "Qatar (‫قطر‬‎)", "RE" => "Réunion (La Réunion)", "RO" => "Romania (România)", "RU" => "Russia (Россия)", "RW" => "Rwanda", "BL" => "Saint Barthélemy (Saint-Barthélemy)", "SH" => "Saint Helena", "KN" => "Saint Kitts and Nevis", "LC" => "Saint Lucia", "MF" => "Saint Martin (Saint-Martin (partie française))", "PM" => "Saint Pierre and Miquelon (Saint-Pierre-et-Miquelon)", "WS" => "Samoa", "SM" => "San Marino", "ST" => "São Tomé and Príncipe (São Tomé e Príncipe)", "SA" => "Saudi Arabia (‫المملكة العربية السعودية‬‎)", "SN" => "Senegal (Sénégal)", "RS" => "Serbia (Србија)", "SC" => "Seychelles", "SL" => "Sierra Leone", "SG" => "Singapore", "SX" => "Sint Maarten", "SK" => "Slovakia (Slovensko)", "SI" => "Slovenia (Slovenija)", "SB" => "Solomon Islands", "SO" => "Somalia (Soomaaliya)", "ZA" => "South Africa", "GS" => "South Georgia & South Sandwich Islands", "KR" => "South Korea (대한민국)", "SS" => "South Sudan (‫جنوب السودان‬‎)", "ES" => "Spain (España)", "LK" => "Sri Lanka (ශ්‍රී ලංකාව)", "VC" => "St. Vincent & Grenadines", "SD" => "Sudan (‫السودان‬‎)", "SR" => "Suriname", "SJ" => "Svalbard and Jan Mayen (Svalbard og Jan Mayen)", "SZ" => "Swaziland", "SE" => "Sweden (Sverige)", "CH" => "Switzerland (Schweiz)", "SY" => "Syria (‫سوريا‬‎)", "TW" => "Taiwan (台灣)", "TJ" => "Tajikistan", "TZ" => "Tanzania", "TH" => "Thailand (ไทย)", "TL" => "Timor-Leste", "TG" => "Togo", "TK" => "Tokelau", "TO" => "Tonga", "TT" => "Trinidad and Tobago", "TA" => "Tristan da Cunha", "TN" => "Tunisia (‫تونس‬‎)", "TR" => "Turkey (Türkiye)", "TM" => "Turkmenistan", "TC" => "Turks and Caicos Islands", "TV" => "Tuvalu", "UM" => "U.S. Outlying Islands", "VI" => "U.S. Virgin Islands", "UG" => "Uganda", "UA" => "Ukraine (Україна)", "AE" => "United Arab Emirates (‫الإمارات العربية المتحدة‬‎)", "GB" => "United Kingdom", "US" => "United States", "UY" => "Uruguay", "UZ" => "Uzbekistan (Oʻzbekiston)", "VU" => "Vanuatu", "VA" => "Vatican City (Città del Vaticano)", "VE" => "Venezuela", "VN" => "Vietnam (Việt Nam)", "WF" => "Wallis and Futuna", "EH" => "Western Sahara (‫الصحراء الغربية‬‎)", "YE" => "Yemen (‫اليمن‬‎)", "ZM" => "Zambia", "ZW" => "Zimbabwe" );

    if(isset($_GET['page'])) {
		$sPage = $_GET['page'];
	} else {
		$sPage = 'dashboard';
	}

    if ($sPage == "dashboard") {
        $includePage = 'php/pages/dashboard.php';
        $script = '
            <!-- c3 charts -->
            <script src="assets/lib/d3/d3.min.js"></script>
            <script src="assets/lib/c3/c3.min.js"></script>
            <!-- vector maps -->
            <script src="assets/lib/jvectormap/jquery-jvectormap-1.2.2.min.js"></script>
            <script src="assets/lib/jvectormap/maps/jquery-jvectormap-world-mill-en.js"></script>
            <!-- countUp animation -->
            <script src="assets/js/countUp.min.js"></script>
            <!-- easePie chart -->
            <script src="assets/lib/easy-pie-chart/dist/jquery.easypiechart.min.js"></script>

            <script>
                $(function() {
                    // c3 charts
                    yukon_charts.p_dashboard();
                    // countMeUp
                    yukon_count_up.init();
                    // easy pie chart
                    yukon_easyPie_chart.p_dashboard();
                    // vector maps
                    yukon_vector_maps.p_dashboard();
                    // match height
                    yukon_matchHeight.p_dashboard();
                })
            </script>
		';
    }

    if ($sPage == "forms-regular_elements") {
        $includePage = 'php/pages/forms-regular_elements.php';
        $breadcrumbs = '<li><span>Forms</span></li><li><span>Regular Elements</span></li>';
    }

    if ($sPage == "forms-extended_elements") {
        $includePage = 'php/pages/forms-extended_elements.php';
        $breadcrumbs = '
                    <li><span>Forms</span></li>
                    <li><span>Extended Elements</span></li>
        ';
        $css = '
            <!-- select2 -->
            <link href="assets/lib/select2/select2.css" rel="stylesheet" media="screen">
            <!-- datepicker -->
            <link href="assets/lib/bootstrap-datepicker/css/datepicker3.css" rel="stylesheet" media="screen">
            <!-- date range picker -->
            <link href="assets/lib/bootstrap-daterangepicker/daterangepicker-bs3.css" rel="stylesheet" media="screen">
            <!-- rangeSlider -->
            <link href="assets/lib/ion.rangeSlider/css/ion.rangeSlider.css" rel="stylesheet" media="screen">
            <link href="assets/lib/ion.rangeSlider/css/ion.rangeSlider.skinFlat.css" rel="stylesheet" media="screen">
            <!-- uplaoder -->
            <link href="assets/lib/plupload/js/jquery.plupload.queue/css/jquery.plupload.queue.css" rel="stylesheet" media="screen">
            <!-- icheck -->
            <link href="assets/lib/iCheck/skins/minimal/blue.css" rel="stylesheet" media="screen">
            <!-- selectize.js -->
            <link href="assets/lib/selectize-js/css/selectize.css" rel="stylesheet" media="screen">
		';
        $script = '
            <!-- select2 -->
            <script src="assets/lib/select2/select2.min.js"></script>
            <!-- datepicker -->
            <script src="assets/lib/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
            <!-- date range picker -->
            <script src="assets/lib/bootstrap-daterangepicker/daterangepicker.js"></script>
            <!-- rangeSlider -->
            <script src="assets/lib/ion.rangeSlider/js/ion-rangeSlider/ion.rangeSlider.min.js"></script>
            <!-- autosize -->
            <script src="assets/lib/autosize/jquery.autosize.min.js"></script>
            <!-- inputmask -->
            <script src="assets/lib/jquery.inputmask/jquery.inputmask.bundle.min.js"></script>
            <!-- maxlength for textareas -->
            <script src="assets/lib/stopVerbosity/stopVerbosity.min.js"></script>
            <!-- uplaoder -->
            <script src="assets/lib/plupload/js/plupload.full.min.js"></script>
            <script src="assets/lib/plupload/js/jquery.plupload.queue/jquery.plupload.queue.min.js"></script>
            <!-- wysiwg editor -->
            <script src="assets/lib/ckeditor/ckeditor.js"></script>
            <script src="assets/lib/ckeditor/adapters/jquery.js"></script>
            <!-- 2col multiselect -->
            <script src="assets/lib/lou-multi-select/js/jquery.multi-select.js"></script>
            <!-- quicksearch -->
            <script src="assets/lib/quicksearch/jquery.quicksearch.min.js"></script>
            <!-- clock picker -->
            <script src="assets/lib/clock-picker/bootstrap-clockpicker.min.js"></script>
            <!-- chained selects -->
            <script src="assets/lib/jquery_chained/jquery.chained.min.js"></script>
            <!-- show/hide passwords -->
            <script src="assets/lib/hideShowPassword/hideShowPassword.min.js"></script>
            <!-- password strength metter -->
            <script src="assets/lib/jquery.pwstrength.bootstrap/pwstrength-bootstrap-1.2.2.min.js"></script>
            <!-- icheck -->
            <script src="assets/lib/iCheck/icheck.min.js"></script>
            <!-- selectize.js -->
            <script src="assets/lib/selectize-js/js/standalone/selectize.min.js"></script>

            <script>
                $(function() {
                    // select2
                    yukon_select2.p_forms_extended();
                    // datepicker
                    yukon_datepicker.p_forms_extended();
                    // date range picker
                    yukon_date_range_picker.p_forms_extended();
                    // rangeSlider
                    yukon_rangeSlider.p_forms_extended();
                    // textarea autosize
                    yukon_textarea_autosize.init();
                    // masked inputs
                    yukon_maskedInputs.p_forms_extended();
                    // maxlength for textareas
                    yukon_textarea_maxlength.p_forms_extended();
                    // multiuploader
                    yukon_uploader.p_forms_extended();
                    // 2col multiselect
                    yukon_2col_multiselect.init();
                    // clock picker
                    yukon_clock_picker.init();
                    // chained selects
                    yukon_chained_selects.init();
                    // password show/hide
                    yukon_pwd_show_hide.init();
                    // password strength metter
                    yukon_pwd_strength_metter.init();
                    // checkboxes & radio buttons
                    yukon_icheck.init();
                    // selectize.js
                    yukon_selectize.p_forms_extended();
                    // wysiwg editor
                    yukon_wysiwg.p_forms_extended();
                })
            </script>
        ';
    }

    if ($sPage == "forms-gridforms") {
        $includePage = 'php/pages/forms-gridforms.php';
        $breadcrumbs = '
		            <li><span>Forms</span></li>
		            <li><span>Gridforms</span></li>
        ';
        $css = '
            <!-- gridforms -->
            <link href="assets/lib/gridforms/gf-forms.min.css" rel="stylesheet" media="screen">
		';
        $script = '
            <!-- gridforms -->
            <script src="assets/lib/gridforms/gf-forms.min.js"></script>
        ';
    }

    if ($sPage == "forms-validation") {
        $includePage = 'php/pages/forms-validation.php';
        $breadcrumbs = '
		            <li><span>Forms</span></li>
		            <li><span>Validation</span></li>
        ';
        $css = '
            <!-- select2 -->
            <link href="assets/lib/select2/select2.css" rel="stylesheet" media="screen">
		';
        $script = '
            <!-- select2 -->
            <script src="assets/lib/select2/select2.min.js"></script>
            <!-- validation (parsley.js) -->
            <script src="assets/js/parsley.config.js"></script>
            <script src="assets/lib/parsley/dist/parsley.min.js"></script>
            <!-- wysiwg editor -->
            <script src="assets/lib/ckeditor/ckeditor.js"></script>
            <script src="assets/lib/ckeditor/adapters/jquery.js"></script>

            <script>
                $(function() {
                    // wysiwg editor
                    yukon_wysiwg.p_forms_validation();
                    // multiselect
                    yukon_select2.p_forms_validation();
                    // validation
                    yukon_parsley_validation.p_forms_validation();
                })
            </script>
        ';
    }

    if ($sPage == "forms-wizard") {
        $includePage = 'php/pages/forms-wizard.php';
        $breadcrumbs = '
		            <li><span>Forms</span></li>
		            <li><span>Wizard</span></li>
		';
        $css = '
            <!-- select2 -->
            <link href="assets/lib/select2/select2.css" rel="stylesheet" media="screen">
            <!-- prism highlight -->
            <link href="assets/lib/prism/prism_default.css" rel="stylesheet" media="screen">
            <link href="assets/lib/prism/line_numbers.css" rel="stylesheet" media="screen">
		';
        $script = '
            <!-- select2 -->
            <script src="assets/lib/select2/select2.min.js"></script>
            <!-- prism highlight -->
            <script src="assets/lib/prism/prism.min.js"></script>
            <!-- jquery steps -->
            <script src="assets/js/jquery.steps.custom.min.js"></script>
            <!-- validation (parsley.js) -->
            <script src="assets/js/parsley.config.js"></script>
            <script src="assets/lib/parsley/dist/parsley.min.js"></script>

            <script>
                $(function() {
                    // wizard
                    yukon_steps.init();
                    // select2 country,languages
                    yukon_select2.p_forms_wizard();
                    // form validation
                    yukon_parsley_validation.p_forms_wizard();
                })
            </script>
        ';
    }

    if ($sPage == "pages-chat") {
        $includePage = 'php/pages/pages-chat.php';
        $breadcrumbs = '
		            <li><span>Pages</span></li>
		            <li><span>Chat</span></li>
		';
        $script = '
            <script>
                $(function() {
                    // chat
                    yukon_chat.init();
                })
            </script>
        ';
    }

    if ($sPage == "pages-contact_list") {
        $includePage = 'php/pages/pages-contact_list.php';
        $breadcrumbs = '
                    <li><span>Pages</span></li>
                    <li><span>Contact List</span></li>
		';
        $script = '
            <!-- shuffle.js -->
            <script src="assets/lib/shuffle/jquery.shuffle.modernizr.min.js"></script>

            <script>
                $(function() {

                    // contact list
                    yukon_contact_list.init();
                })
            </script>
        ';
    }

    if ($sPage == "pages-help_faq") {
        $includePage = 'php/pages/pages-help_faq.php';
        $breadcrumbs = '
                    <li><span>Pages</span></li>
                    <li><span>Help/Faq</span></li>
		';
    }

    if ($sPage == "pages-invoices") {
        $includePage = 'php/pages/pages-invoices.php';
        $breadcrumbs = '
		            <li><span>Pages</span></li>
		            <li><span>Invoices</span></li>
		';
        $script = '
            <!-- qrcode -->
            <script src="assets/lib/jquery-qrcode-0.10.1/jquery.qrcode-0.10.1.min"></script>

            <script>
                $(function() {
                    // qrcode
                    yukon_qrcode.p_pages_invoices();
                })
            </script>
        ';
    }

    if ($sPage == "pages-mailbox") {
        $includePage = 'php/pages/pages-mailbox.php';
        $breadcrumbs = '
		            <li><span>Pages</span></li>
		            <li><span>Mailbox</span></li>
		';
        $css = '
            <!-- footable -->
            <link href="assets/lib/footable/css/footable.core.min.css" rel="stylesheet" media="screen">
		';
        $script = '
            <!-- footable -->
            <script src="assets/lib/footable/footable.min.js"></script>
            <script src="assets/lib/footable/footable.paginate.min.js"></script>
            <script src="assets/lib/footable/footable.filter.min.js"></script>

            <script>
                $(function() {
                    // footable
                    yukon_footable.p_pages_mailbox();

                    yukon_mailbox.init();
                })
            </script>
        ';
    }

    if ($sPage == "pages-mailbox_message") {
        $includePage = 'php/pages/pages-mailbox_message.php';
        $breadcrumbs = '
                    <li><span>Pages</span></li>
                    <li><a href="pages-mailbox.html">Mailbox</a></li>
                    <li><span>Details</span></li>
		';
    }

    if ($sPage == "pages-mailbox_compose") {
        $includePage = 'php/pages/pages-mailbox_compose.php';
        $breadcrumbs = '
                    <li><span>Pages</span></li>
                    <li><a href="pages-mailbox.html">Mailbox</a></li>
                    <li><span>Compose Mail</span></li>
		';
        $css = '
            <!-- summernote -->
            <link href="assets/lib/summernote/summernote.css" rel="stylesheet" media="screen">
		';
        $script = '
            <!-- summernote -->
            <link href="http://maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet">
            <script src="assets/lib/summernote/summernote.min.js"></script>

            <script>
                $(function() {
                    $(\'#wysiwyg_compose\').summernote({
                        height: 300
                    });
                })
            </script>
        ';
    }

    if ($sPage == "pages-search_page") {
        $includePage = 'php/pages/pages-search_page.php';
        $breadcrumbs = '
		            <li><span>Pages</span></li>
		            <li><span>Search Page</span></li>
		';
    }

    if ($sPage == "pages-user_list") {
        $includePage = 'php/pages/pages-user_list.php';
        $breadcrumbs = '
                    <li><span>Pages</span></li>
                    <li><span>User List</span></li>
		';
        $script = '
            <!-- iOS list -->
            <script src="assets/lib/jquery-listnav/dist/js/jquery-listnav-2.4.0.min.js"></script>

            <script>
                $(function() {
                    // count users
                    yukon_user_list.init();

                    // iOS list
                    yukon_listNav.p_pages_user_list();
                })
            </script>
        ';
    }

    if ($sPage == "pages-user_profile") {
        $includePage = 'php/pages/pages-user_profile.php';
        $breadcrumbs = '
		            <li><span>Pages</span></li>
		            <li><span>User Profile</span></li>
		';
        $script = '
            <!-- easePie chart -->
            <script src="assets/lib/easy-pie-chart/dist/jquery.easypiechart.min.js"></script>

            <script>
                $(function() {
                    // easePie chart
                    yukon_easyPie_chart.p_pages_user_profile();
                })
            </script>
        ';
    }

    if ($sPage == "pages-user_profile2") {
        $includePage = 'php/pages/pages-user_profile2.php';
        $breadcrumbs = '
		            <li><span>Pages</span></li>
		            <li><span>User Profile 2</span></li>
		';
    }

    if ($sPage == "components-bootstrap") {
        $includePage = 'php/pages/components-bootstrap.php';
        $breadcrumbs = '
		            <li><span>Components</span></li>
		            <li><span>Bootstrap Framework</span></li>
		';
    }

    if ($sPage == "components-gallery") {
        $includePage = 'php/pages/components-gallery.php';
        $breadcrumbs = '
		            <li><span>Components</span></li>
		            <li><span>Gallery</span></li>
		';
        $css = '
            <!-- magnific -->
            <link href="assets/lib/magnific-popup/magnific-popup.css" rel="stylesheet" media="screen">
		';
        $script = '
            <!-- magnific -->
            <script src="assets/lib/magnific-popup/jquery.magnific-popup.min.js"></script>

            <script>
                $(function() {
                    // gallery filter
                    yukon_gallery.search_gallery();
                    // magnific lightbox
                    yukon_magnific.p_components_gallery();
                })
            </script>
        ';
    }

    if ($sPage == "components-grid") {
        $includePage = 'php/pages/components-grid.php';
        $breadcrumbs = '
		            <li><span>Components</span></li>
		            <li><span>Grid</span></li>
		';
    }

    if ($sPage == "components-icons") {
        $includePage = 'php/pages/components-icons.php';
        $breadcrumbs = '
		            <li><span>Components</span></li>
		            <li><span>Icons</span></li>
		';
        $script = '
            <script>
                $(function() {
                    // icon filter
                    yukon_icons.search_icons();
                })
            </script>
        ';
    }

    if ($sPage == "components-notifications_popups") {
        $includePage = 'php/pages/components-notifications_popups.php';
        $breadcrumbs = '
		            <li><span>Components</span></li>
		            <li><span>Notifications/Popups</span></li>
		';
        $css = '
            <!-- jBox -->
            <link href="assets/lib/jBox-0.3.0/Source/jBox.css" rel="stylesheet" media="screen">
            <link href="assets/lib/jBox-0.3.0/Source/themes/NoticeBorder.css" rel="stylesheet" media="screen">
		';
        $script = '
            <!-- jBox -->
            <script src="assets/lib/jBox-0.3.0/Source/jBox.min.js"></script>

            <script>
                $(function() {
                    // jBox
                    yukon_jBox.p_components_notifications_popups();
                })
            </script>
        ';
    }

    if ($sPage == "components-typography") {
        $includePage = 'php/pages/components-typography.php';
        $breadcrumbs = '
		            <li><span>Components</span></li>
		            <li><span>Typography</span></li>
		';
    }

    if ($sPage == "plugins-ace_editor") {
        $includePage = 'php/pages/plugins-ace_editor.php';
        $breadcrumbs = '
		            <li><span>Plugins</span></li>
		            <li><span>Ace Editor</span></li>
		';
        $css = '
            <!-- source code pro google fonts -->
            <link href="http://fonts.googleapis.com/css?family=Source+Code+Pro" rel="stylesheet" media="screen">
		';
        $script = '
            <!-- ace editor -->
            <script src="assets/lib/ace/src-min-noconflict/ace.js"></script>
            <script>
                $(function() {
                    // ace editor
                    yukon_ace_editor.init();
                })
            </script>
        ';
    }

    if ($sPage == "plugins-calendar") {
        $includePage = 'php/pages/plugins-calendar.php';
        $breadcrumbs = '
                    <li><span>Plugins</span></li>
                    <li><span>Calendar</span></li>
		';
        $css = '
            <!-- full calendar -->
            <link href="assets/lib/fullcalendar/fullcalendar.css" rel="stylesheet" media="screen">
		';
        $script = '
            <!-- jquery UI -->
            <script src="assets/lib/fullcalendar/lib/jquery-ui.custom.min.js"></script>
            <!-- full calendar -->
            <script src="assets/lib/fullcalendar/fullcalendar.min.js"></script>
            <script src="assets/lib/fullcalendar/gcal.js"></script>
            <script>
                $(function() {
                    // full calendar
                    yukon_fullCalendar.p_plugins_calendar();
                })
            </script>
        ';
    }

    if ($sPage == "plugins-charts") {
        $includePage = 'php/pages/plugins-charts.php';
        $breadcrumbs = '
		            <li><span>Plugins</span></li>
		            <li><span>Charts</span></li>
		';
        $script = '
            <!-- c3 charts -->
            <script src="assets/lib/d3/d3.min.js"></script>
            <script src="assets/lib/c3/c3.min.js"></script>
            <script>
                $(function() {
                    // c3 charts
                    yukon_charts.p_plugins_charts();
                })
            </script>
        ';
    }

    if ($sPage == "plugins-gantt_chart") {
        $includePage = 'php/pages/plugins-gantt_chart.php';
        $breadcrumbs = '
		            <li><span>Plugins</span></li>
		            <li><span>Gantt Chart</span></li>
		';
        $script = '
            <!-- gantt chart -->
            <script src="assets/lib/jquery.ganttView/jquery-ui.min.js"></script>
            <script src="assets/lib/jquery.ganttView/date.js"></script>
            <script src="assets/lib/jquery.ganttView/jquery.ganttView.js"></script>
            <script>
                $(function() {
                    // gantt chart
                    yukon_gantt_chart.init();
                })
            </script>
        ';
    }

    if ($sPage == "plugins-google_maps") {
        $includePage = 'php/pages/plugins-google_maps.php';
        $breadcrumbs = '
		            <li><span>Plugins</span></li>
		            <li><span>Google Maps</span></li>
		';
        $script = '
            <!-- gmaps -->
            <script src="assets/lib/gmaps/gmaps.js"></script>
            <script>
                $(function() {
                    // gmaps
                    yukon_gmaps.init();
                })
            </script>
        ';
    }

    if ($sPage == "plugins-tables_footable") {
        $includePage = 'php/pages/plugins-tables_footable.php';
        $breadcrumbs = '
		            <li><span>Plugins</span></li>
		            <li><span>Tables</span></li>
		            <li><span>Footable</span></li>
		';
        $css = '
            <!-- footable -->
            <link href="assets/lib/footable/css/footable.core.min.css" rel="stylesheet" media="screen">
        ';
        $script = '
            <!-- footable -->
            <script src="assets/lib/footable/footable.min.js"></script>
            <script src="assets/lib/footable/footable.paginate.min.js"></script>
            <script src="assets/lib/footable/footable.filter.min.js"></script>

            <script>
                $(function() {
                    // footable
                    yukon_footable.p_plugins_tables_footable();
                })
            </script>
        ';
    }

    if ($sPage == "plugins-tables_datatable") {
        $includePage = 'php/pages/plugins-tables_datatable.php';
        $breadcrumbs = '
		            <li><span>Plugins</span></li>
		            <li><span>Tables</span></li>
		            <li><span>Datatable</span></li>
		';
        $script = '
            <!-- datatable -->
            <script src="assets/lib/DataTables/media/js/jquery.dataTables.min.js"></script>
            <script src="assets/lib/DataTables/extensions/FixedHeader/js/dataTables.fixedHeader.min.js"></script>
            <script src="assets/lib/DataTables/media/js/dataTables.bootstrap.js"></script>

            <script>
                $(function() {
                    // footable
                    yukon_datatables.p_plugins_tables_datatable();
                })
            </script>
        ';
    }

    if ($sPage == "plugins-vector_maps") {
        $includePage = 'php/pages/plugins-vector_maps.php';
        $breadcrumbs = '
		            <li><span>Plugins</span></li>
		            <li><span>Vector Maps</span></li>
		';
        $script = '
            <!-- vector maps -->
            <script src="assets/lib/jvectormap/jquery-jvectormap-1.2.2.min.js"></script>
            <script src="assets/lib/jvectormap/maps/jquery-jvectormap-world-mill-en.js"></script>
            <script src="assets/lib/jvectormap/maps/jquery-jvectormap-ca-mill-en.js"></script>

            <script>
                $(function() {
                    // vector maps
                    yukon_vector_maps.p_plugins_vector_maps();
                })
            </script>
        ';
    }
