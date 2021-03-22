// 依懒以下js 和 css
// sweetalert.js
// sweetalert.css
// jquery.js
// layer.js
// vue.js
(function () {
    var large = {
        load: function (title, text) { // 弹出加载层
            return layer.load(0, {shade: 0.2})
        },
        loading: function (msg){
            return (new Vue).$loading({
                lock: true,
                text: msg,
                spinner: 'el-icon-loading',
                background: 'rgba(0, 0, 0, 0.6)'
            });
        },
        msg: function (msg, callback, param = {icon: 1, times: 1000, shadeClose: true, shade: 0.2}) {
            return layer.msg(msg, {
                icon: param.icon,
                time: param.times,
                shadeClose: param.shadeClose,
                shade: param.shade
            }, callback)
        },
        timingJump: function(type = 1, time = 1000, url = '/'){ // 定时刷新或者跳转
            setTimeout((res = type)=>{
                if (res) {
                    location.reload();
                }else{
                    window.location = url;
                }
            }, time);
        },
        message: function (msg, type = 'success', timingJump = '') {
            app.$message({
                message: msg,
                type: type
            });
            return timingJump;
        },
        swal: function (msg, title = '', icon = 'success') {
            swal(msg, title, icon)
        },
        confirm: function (msg, hint = '提示', type = 'warning') {
            return (new Vue()).$confirm(msg, hint, {
                confirmButtonText: '确定',
                cancelButtonText: '取消',
                type
            });
        },
        openImg(src) { // 弹出 图片
            var imgHtml = "<img src='" + src + "' width='500' style='padding: 10px;' />";
            //弹出层
            layer.open({
                type: 1,
                title: false,//不显示标题
                closeBtn: 0,
                area: ['auto', 'auto'],
                // skin: 'layui-layer-nobg', //没有背景色
                shadeClose: true,
                content: imgHtml
            });
        },
        openHtml(url, area, param = {title: false, shadeClose: false}) {
            //弹出层
            layer.open({
                type: 2,
                title: param.title,//不显示标题
                // closeBtn: 0,
                area: area,
                // skin: 'layui-layer-nobg', //没有背景色
                shadeClose: param.shadeClose,
                content: url
            });
        },
        get: function (url, callback) { // GET 请求
            var topLoad = this.load('loading', 'Data loading')
            return $.ajax({
                url: url,
                type: 'get',
                success: function (res) {
                    callback(res);
                    layer.close(topLoad);
                },
                error: function (err) {
                    callback(err);
                    layer.close(topLoad);
                }
            });
        },
        post: function (url, data, callback) { // POST 请求
            var topLoad = this.loading('loading')
            return $.ajax({
                url: url,
                type: 'post',
                data: data,
                success: function (res) {
                    callback(res);
                    topLoad.close();
                },
                error: function (err) {
                    callback(err);
                    topLoad.close();
                }
            });
        },
        rules: function (arr, rules) { // 字段验证是否为空
            var html = '';
            $.each(arr, function (k, v) {
                if (v instanceof Object) {
                    $.each(v, function (kk, vv) {
                        if (vv == '') {
                            html += rules[kk] + ' 不可为空';
                            return false;
                        }
                    })
                    return false;
                }
                if (v == '') {
                    html += rules[k] + ' 不可为空';
                    return false;
                }
            })
            return html;
        },
        verifyRules: function (callback) {
            // 提交前验证是否填写
            var res = callback;
            if (res != ''){
                this.message(res, 'error');
                return false;
            }
            return true;
        },
        nationality: function () { // 国籍插件
            return allCountries = [
                {value: '', laber: '--请选择--'},
                {value: 'China (中国)', laber: 'China (中国)'},
                {value: 'Hong Kong (中国香港)', laber: 'Hong Kong (中国香港)'},
                {value: 'Afghanistan (افغانستان)', laber: 'Afghanistan (افغانستان)'},
                {value: 'Albania (Shqipëri)', laber: 'Albania (Shqipëri)'},
                {value: 'Algeria (الجزائر)', laber: 'Algeria (الجزائر)'},
                {value: 'American Samoa', laber: 'American Samoa'},
                {value: 'Andorra', laber: 'Andorra'},
                {value: 'Angola', laber: 'Angola'},
                {value: 'Anguilla', laber: 'Anguilla'},
                {value: 'Antigua and Barbuda', laber: 'Antigua and Barbuda'},
                {value: 'Argentina', laber: 'Argentina'},
                {value: 'Armenia (Հայաստան)', laber: 'Armenia (Հայաստան)'},
                {value: 'Aruba', laber: 'Aruba'},
                {value: 'Australia', laber: 'Australia'},
                {value: 'Austria (Österreich)', laber: 'Austria (Österreich)'},
                {value: 'Azerbaijan (Azərbaycan)', laber: 'Azerbaijan (Azərbaycan)'},
                {value: 'Bahamas', laber: 'Bahamas'},
                {value: 'Bahrain (البحرين)', laber: 'Bahrain (البحرين)'},
                {value: 'Bangladesh (বাংলাদেশ)', laber: 'Bangladesh (বাংলাদেশ)'},
                {value: 'Barbados', laber: 'Barbados'},
                {value: 'Belarus (Беларусь)', laber: 'Belarus (Беларусь)'},
                {value: 'Belgium (België)', laber: 'Belgium (België)'},
                {value: 'Belize', laber: 'Belize'},
                {value: 'Benin (Bénin)', laber: 'Benin (Bénin)'},
                {value: 'Bermuda', laber: 'Bermuda'},
                {value: 'Bhutan (འབྲུག)', laber: 'Bhutan (འབྲུག)'},
                {value: 'Bolivia', laber: 'Bolivia'},
                {
                    value: 'Bosnia and Herzegovina (Босна и Херцеговина)',
                    laber: 'Bosnia and Herzegovina (Босна и Херцеговина)'
                },
                {value: 'Botswana', laber: 'Botswana'},
                {value: 'Brazil (Brasil)', laber: 'Brazil (Brasil)'},
                {value: 'British Indian Ocean Territory', laber: 'British Indian Ocean Territory'},
                {value: 'British Virgin Islands', laber: 'British Virgin Islands'},
                {value: 'Brunei', laber: 'Brunei'},
                {value: 'Bulgaria (България)', laber: 'Bulgaria (България)'},
                {value: 'Burkina Faso', laber: 'Burkina Faso'},
                {value: 'Burundi (Uburundi)', laber: 'Burundi (Uburundi)'},
                {value: 'Cambodia (កម្ពុជា)', laber: 'Cambodia (កម្ពុជា)'},
                {value: 'Cameroon (Cameroun)', laber: 'Cameroon (Cameroun)'},
                {value: 'Canada', laber: 'Canada'},
                {value: 'Cape Verde (Kabu Verdi)', laber: 'Cape Verde (Kabu Verdi)'},
                {value: 'Caribbean Netherlands', laber: 'Caribbean Netherlands'},
                {value: 'Cayman Islands', laber: 'Cayman Islands'},
                {
                    value: 'Central African Republic (République centrafricaine)',
                    laber: 'Central African Republic (République centrafricaine)'
                },
                {value: 'Chad (Tchad)', laber: 'Chad (Tchad)'},
                {value: 'Chile', laber: 'Chile'},
                {value: 'Christmas Island', laber: 'Christmas Island'},
                {value: 'Cocos (Keeling) Islands', laber: 'Cocos (Keeling) Islands'},
                {value: 'Colombia', laber: 'Colombia'},
                {value: 'Comoros (جزر القمر)', laber: 'Comoros (جزر القمر)'},
                {
                    value: 'Congo (DRC) (Jamhuri ya Kidemokrasia ya Kongo)',
                    laber: 'Congo (DRC) (Jamhuri ya Kidemokrasia ya Kongo)'
                },
                {value: 'Congo (Republic) (Congo-Brazzaville)', laber: 'Congo (Republic) (Congo-Brazzaville)'},
                {value: 'Cook Islands', laber: 'Cook Islands'},
                {value: 'Costa Rica', laber: 'Costa Rica'},
                {value: 'Côte d’Ivoire', laber: 'Côte d’Ivoire'},
                {value: 'Croatia (Hrvatska)', laber: 'Croatia (Hrvatska)'},
                {value: 'Cuba', laber: 'Cuba'},
                {value: 'Curaçao', laber: 'Curaçao'},
                {value: 'Cyprus (Κύπρος)', laber: 'Cyprus (Κύπρος)'},
                {value: 'Czech Republic (Česká republika)', laber: 'Czech Republic (Česká republika)'},
                {value: 'Denmark (Danmark)', laber: 'Denmark (Danmark)'},
                {value: 'Djibouti', laber: 'Djibouti'},
                {value: 'Dominica', laber: 'Dominica'},
                {
                    value: 'Dominican Republic (República Dominicana)',
                    laber: 'Dominican Republic (República Dominicana)'
                },
                {value: 'Ecuador', laber: 'Ecuador'},
                {value: 'Egypt (مصر) )', laber: 'Egypt (مصر) )'},
                {value: 'El Salvador', laber: 'El Salvador'},
                {value: 'Equatorial Guinea (Guinea Ecuatorial)', laber: 'Equatorial Guinea (Guinea Ecuatorial)'},
                {value: 'Eritrea', laber: 'Eritrea'},
                {value: 'Estonia (Eesti)', laber: 'Estonia (Eesti)'},
                {value: 'Ethiopia', laber: 'Ethiopia'},
                {value: 'Falkland Islands (Islas Malvinas)', laber: 'Falkland Islands (Islas Malvinas)'},
                {value: 'Faroe Islands (Føroyar)', laber: 'Faroe Islands (Føroyar)'},
                {value: 'Fiji', laber: 'Fiji'},
                {value: 'Finland (Suomi)', laber: 'Finland (Suomi)'},
                {value: 'France', laber: 'France'},
                {value: 'French Guiana (Guyane française)', laber: 'French Guiana (Guyane française)'},
                {value: 'French Polynesia (Polynésie française)', laber: 'French Polynesia (Polynésie française)'},
                {value: 'Gabon', laber: 'Gabon'},
                {value: 'Gambia', laber: 'Gambia'},
                {value: 'Georgia (საქართველო)', laber: 'Georgia (საქართველო)'},
                {value: 'Germany (Deutschland)', laber: 'Germany (Deutschland)'},
                {value: 'Ghana (Gaana)', laber: 'Ghana (Gaana)'},
                {value: 'Gibraltar', laber: 'Gibraltar'},
                {value: 'Greece (Ελλάδα)', laber: 'Greece (Ελλάδα)'},
                {value: 'Greenland (Kalaallit Nunaat)', laber: 'Greenland (Kalaallit Nunaat)'},
                {value: 'Grenada', laber: 'Grenada'},
                {value: 'Guadeloupe', laber: 'Guadeloupe'},
                {value: 'Guam', laber: 'Guam'},
                {value: 'Guatemala', laber: 'Guatemala'},
                {value: 'Guernsey', laber: 'Guernsey'},
                {value: 'Guinea (Guinée)', laber: 'Guinea (Guinée)'},
                {value: 'Guinea-Bissau (Guiné Bissau)', laber: 'Guinea-Bissau (Guiné Bissau)'},
                {value: 'Guyana', laber: 'Guyana'},
                {value: 'Haiti', laber: 'Haiti'},
                {value: 'Honduras', laber: 'Honduras'},
                {value: 'Hungary (Magyarország)', laber: 'Hungary (Magyarország)'},
                {value: 'Iceland (Ísland)', laber: 'Iceland (Ísland)'},
                {value: 'India (भारत)', laber: 'India (भारत)'},
                {value: 'Indonesia', laber: 'Indonesia'},
                {value: 'Iran (ایران)', laber: 'Iran (ایران)'},
                {value: 'Iraq (العراق)', laber: 'Iraq (العراق)'},
                {value: 'Ireland', laber: 'Ireland'},
                {value: 'Isle of Man', laber: 'Isle of Man'},
                {value: 'Israel (ישראל)', laber: 'Israel (ישראל)'},
                {value: 'Italy (Italia)', laber: 'Italy (Italia)'},
                {value: 'Jamaica', laber: 'Jamaica'},
                {value: 'Japan (日本)', laber: 'Japan (日本)'},
                {value: 'Jersey', laber: 'Jersey'},
                {value: 'Jordan (الأردن)', laber: 'Jordan (الأردن)'},
                {value: 'Kazakhstan (Казахстан)', laber: 'Kazakhstan (Казахстан)'},
                {value: 'Kenya', laber: 'Kenya'},
                {value: 'Kiribati', laber: 'Kiribati'},
                {value: 'Kosovo', laber: 'Kosovo'},
                {value: 'Kuwait (الكويت)', laber: 'Kuwait (الكويت)'},
                {value: 'Kyrgyzstan (Кыргызстан)', laber: 'Kyrgyzstan (Кыргызстан)'},
                {value: 'Laos (ລາວ)', laber: 'Laos (ລາວ)'},
                {value: 'Latvia (Latvija)', laber: 'Latvia (Latvija)'},
                {value: 'Lebanon (لبنان)', laber: 'Lebanon (لبنان)'},
                {value: 'Lesotho', laber: 'Lesotho'},
                {value: 'Liberia', laber: 'Liberia'},
                {value: 'Libya (ليبيا)', laber: 'Libya (ليبيا)'},
                {value: 'Liechtenstein', laber: 'Liechtenstein'},
                {value: 'Lithuania (Lietuva)', laber: 'Lithuania (Lietuva)'},
                {value: 'Luxembourg', laber: 'Luxembourg'},
                {value: 'Macau (中國澳門)', laber: 'Macau (中國澳門)'},
                {value: 'Macedonia (FYROM) (Македонија)', laber: 'Macedonia (FYROM) (Македонија)'},
                {value: 'Madagascar (Madagasikara)', laber: 'Madagascar (Madagasikara)'},
                {value: 'Malawi', laber: 'Malawi'},
                {value: 'Malaysia', laber: 'Malaysia'},
                {value: 'Maldives', laber: 'Maldives'},
                {value: 'Mali', laber: 'Mali'},
                {value: 'Malta', laber: 'Malta'},
                {value: 'Marshall Islands', laber: 'Marshall Islands'},
                {value: 'Martinique', laber: 'Martinique'},
                {value: 'Mauritania (موريتانيا)', laber: 'Mauritania (موريتانيا)'},
                {value: 'Mauritius (Moris)', laber: 'Mauritius (Moris)'},
                {value: 'Mayotte', laber: 'Mayotte'},
                {value: 'Mexico (México)', laber: 'Mexico (México)'},
                {value: 'Micronesia', laber: 'Micronesia'},
                {value: 'Moldova (Republica Moldova)', laber: 'Moldova (Republica Moldova)'},
                {value: 'Monaco', laber: 'Monaco'},
                {value: 'Mongolia (Монгол)', laber: 'Mongolia (Монгол)'},
                {value: 'Montenegro (Crna Gora)', laber: 'Montenegro (Crna Gora)'},
                {value: 'Montserrat', laber: 'Montserrat'},
                {value: 'Morocco (المغرب)', laber: 'Morocco (المغرب)'},
                {value: 'Mozambique (Moçambique)', laber: 'Mozambique (Moçambique)'},
                {value: 'Myanmar (Burma) (မြန်မာ)', laber: 'Myanmar (Burma) (မြန်မာ)'},
                {value: 'Namibia (Namibië)', laber: 'Namibia (Namibië)'},
                {value: 'Nauru', laber: 'Nauru'},
                {value: 'Nepal (नेपाल)', laber: 'Nepal (नेपाल)'},
                {value: 'Netherlands (Nederland)', laber: 'Netherlands (Nederland)'},
                {value: 'New Caledonia (Nouvelle-Calédonie)', laber: 'New Caledonia (Nouvelle-Calédonie)'},
                {value: 'New Zealand', laber: 'New Zealand'},
                {value: 'Nicaragua', laber: 'Nicaragua'},
                {value: 'Niger (Nijar)', laber: 'Niger (Nijar)'},
                {value: 'Nigeria', laber: 'Nigeria'},
                {value: 'Niue', laber: 'Niue'},
                {value: 'Norfolk Island', laber: 'Norfolk Island'},
                {value: 'North Korea (조선 민주주의 인민 공화국)', laber: 'North Korea (조선 민주주의 인민 공화국)'},
                {value: 'Northern Mariana Islands', laber: 'Northern Mariana Islands'},
                {value: 'Norway (Norge)', laber: 'Norway (Norge)'},
                {value: 'Oman (عُمان)', laber: 'Oman (عُمان)'},
                {value: 'Pakistan (پاکستان)', laber: 'Pakistan (پاکستان)'},
                {value: 'Palau', laber: 'Palau'},
                {value: 'Palestine (فلسطين)', laber: 'Palestine (فلسطين)'},
                {value: 'Panama (Panamá)', laber: 'Panama (Panamá)'},
                {value: 'Papua New Guinea', laber: 'Papua New Guinea'},
                {value: 'Paraguay', laber: 'Paraguay'},
                {value: 'Peru (Perú)', laber: 'Peru (Perú)'},
                {value: 'Philippines', laber: 'Philippines'},
                {value: 'Poland (Polska)', laber: 'Poland (Polska)'},
                {value: 'Portugal', laber: 'Portugal'},
                {value: 'Puerto Rico', laber: 'Puerto Rico'},
                {value: 'Qatar (قطر)', laber: 'Qatar (قطر)'},
                {value: 'Réunion (La Réunion)', laber: 'Réunion (La Réunion)'},
                {value: 'Romania (România)', laber: 'Romania (România)'},
                {value: 'Russia (Россия)', laber: 'Russia (Россия)'},
                {value: 'Rwanda', laber: 'Rwanda'},
                {value: 'Saint Barthélemy', laber: 'Saint Barthélemy'},
                {value: 'Saint Helena', laber: 'Saint Helena'},
                {value: 'Saint Kitts and Nevis', laber: 'Saint Kitts and Nevis'},
                {value: 'Saint Lucia', laber: 'Saint Lucia'},
                {
                    value: 'Saint Martin (Saint-Martin (partie française))',
                    laber: 'Saint Martin (Saint-Martin (partie française))'
                },
                {
                    value: 'Saint Pierre and Miquelon (Saint-Pierre-et-Miquelon)',
                    laber: 'Saint Pierre and Miquelon (Saint-Pierre-et-Miquelon)'
                },
                {value: 'Saint Vincent and the Grenadines', laber: 'Saint Vincent and the Grenadines'},
                {value: 'Samoa', laber: 'Samoa'},
                {value: 'San Marino', laber: 'San Marino'},
                {
                    value: 'São Tomé and Príncipe (São Tomé e Príncipe)',
                    laber: 'São Tomé and Príncipe (São Tomé e Príncipe)'
                },
                {value: 'Saudi Arabia (المملكة العربية السعودية)', laber: 'Saudi Arabia (المملكة العربية السعودية)'},
                {value: 'Senegal (Sénégal)', laber: 'Senegal (Sénégal)'},
                {value: 'Serbia (Србија)', laber: 'Serbia (Србија)'},
                {value: 'Seychelles', laber: 'Seychelles'},
                {value: 'Sierra Leone', laber: 'Sierra Leone'},
                {value: 'Singapore', laber: 'Singapore'},
                {value: 'Sint Maarten', laber: 'Sint Maarten'},
                {value: 'Slovakia (Slovensko)', laber: 'Slovakia (Slovensko)'},
                {value: 'Slovenia (Slovenija)', laber: 'Slovenia (Slovenija)'},
                {value: 'Solomon Islands', laber: 'Solomon Islands'},
                {value: 'Somalia (Soomaaliya)', laber: 'Somalia (Soomaaliya)'},
                {value: 'South Africa', laber: 'South Africa'},
                {value: 'South Korea (대한민국)', laber: 'South Korea (대한민국)'},
                {value: 'South Sudan (جنوب السودان)', laber: 'South Sudan (جنوب السودان)'},
                {value: 'Spain (España)', laber: 'Spain (España)'},
                {value: 'Sri Lanka (ශ්‍රී ලංකාව)', laber: 'Sri Lanka (ශ්‍රී ලංකාව)'},
                {value: 'Sudan (السودان)', laber: 'Sudan (السودان)'},
                {value: 'Suriname', laber: 'Suriname'},
                {value: 'Svalbard and Jan Mayen', laber: 'Svalbard and Jan Mayen'},
                {value: 'Swaziland', laber: 'Swaziland'},
                {value: 'Sweden (Sverige)', laber: 'Sweden (Sverige)'},
                {value: 'Switzerland (Schweiz)', laber: 'Switzerland (Schweiz)'},
                {value: 'Syria (سوريا)', laber: 'Syria (سوريا)'},
                {value: 'Taiwan (中国台灣)', laber: 'Taiwan (中国台灣)'},
                {value: 'Tajikistan', laber: 'Tajikistan'},
                {value: 'Tanzania', laber: 'Tanzania'},
                {value: 'Thailand (ไทย)', laber: 'Thailand (ไทย)'},
                {value: 'Timor-Leste', laber: 'Timor-Leste'},
                {value: 'Togo', laber: 'Togo'},
                {value: 'Tokelau', laber: 'Tokelau'},
                {value: 'Tonga', laber: 'Tonga'},
                {value: 'Trinidad and Tobago', laber: 'Trinidad and Tobago'},
                {value: 'Tunisia (تونس)', laber: 'Tunisia (تونس)'},
                {value: 'Turkey (Türkiye)', laber: 'Turkey (Türkiye)'},
                {value: 'Turkmenistan', laber: 'Turkmenistan'},
                {value: 'Turks and Caicos Islands', laber: 'Turks and Caicos Islands'},
                {value: 'Tuvalu', laber: 'Tuvalu'},
                {value: 'U.S. Virgin Islands', laber: 'U.S. Virgin Islands'},
                {value: 'Uganda', laber: 'Uganda'},
                {value: 'Ukraine (Україна)', laber: 'Ukraine (Україна)'},
                {
                    value: 'United Arab Emirates (الإمارات العربية المتحدة)',
                    laber: 'United Arab Emirates (الإمارات العربية المتحدة)'
                },
                {value: 'United Kingdom', laber: 'United Kingdom'},
                {value: 'United States', laber: 'United States'},
                {value: 'Uruguay', laber: 'Uruguay'},
                {value: 'Uzbekistan (Oʻzbekiston)', laber: 'Uzbekistan (Oʻzbekiston)'},
                {value: 'Vanuatu', laber: 'Vanuatu'},
                {value: 'Vatican City (Città del Vaticano)', laber: 'Vatican City (Città del Vaticano)'},
                {value: 'Venezuela', laber: 'Venezuela'},
                {value: 'Vietnam (Việt Nam)', laber: 'Vietnam (Việt Nam)'},
                {value: 'Wallis and Futuna (Wallis-et-Futuna)', laber: 'Wallis and Futuna (Wallis-et-Futuna)'},
                {value: 'Western Sahara (الصحراء الغربية)', laber: 'Western Sahara (الصحراء الغربية)'},
                {value: 'Yemen (اليمن)', laber: 'Yemen (اليمن)'},
                {value: 'Zambia', laber: 'Zambia'},
                {value: 'Zimbabwe', laber: 'Zimbabwe'},
                {value: 'Åland Islands', laber: 'Åland Islands'}
            ];
        }
    }
    
    window.large = large
})()

