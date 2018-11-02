<html>
<head>
    <title>INIpay50 부분취소 데모</title>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <link rel="stylesheet" href="css/group.css" type="text/css">
    <style>
        body, tr, td {
            font-size: 10pt;
            font-family: 굴림, verdana;
            color: #433F37;
            line-height: 19px;
        }

        table, img {
            border: none
        }

        /* Padding ******/
        .pl_01 {
            padding: 1 10 0 10;
            line-height: 19px;
        }

        .pl_03 {
            font-size: 20pt;
            font-family: 굴림, verdana;
            color: #FFFFFF;
            line-height: 29px;
        }

        /* Link ******/
        .a:link {
            font-size: 9pt;
            color: #333333;
            text-decoration: none
        }

        .a:visited {
            font-size: 9pt;
            color: #333333;
            text-decoration: none
        }

        .a:hover {
            font-size: 9pt;
            color: #0174CD;
            text-decoration: underline
        }

        .txt_03a:link {
            font-size: 8pt;
            line-height: 18px;
            color: #333333;
            text-decoration: none
        }

        .txt_03a:visited {
            font-size: 8pt;
            line-height: 18px;
            color: #333333;
            text-decoration: none
        }

        .txt_03a:hover {
            font-size: 8pt;
            line-height: 18px;
            color: #EC5900;
            text-decoration: underline
        }
    </style>

    <script language="javascript">

        var openwin;

        function repay() {
            // 더블클릭으로 인한 중복승인을 방지하려면 반드시 confirm()을
            // 사용하십시오.
            if (document.ini.oldtid.value == "") {
                alert("원거래 TID가 빠졌습니다. 필수항목입니다.");
                return false;
            }
            else if (document.ini.price.value == "") {
                alert("취소할 금액이 빠졌습니다. 필수항목입니다.");
                return false;
            }
            else if (document.ini.confirm_price.value == "") {
                alert("승인요청금액이 빠졌습니다. 필수항목입니다.");
                return false;
            }
            else if (document.ini.buyeremail.value == "") {
                alert("구매자 이메일 주소가 빠졌습니다. 필수항목입니다.");
                return false;
            }
            else if (confirm("부분취소 하시겠습니까?")) {
                disable_click();
                //openwin = window.open("childwin.html","childwin","width=299,height=149");
                return true;
            }
            else {
                return false;
            }
        }

        function enable_click() {
            document.ini.clickcontrol.value = "enable"
        }

        function disable_click() {
            document.ini.clickcontrol.value = "disable"
        }

        function focus_control() {
            if (document.ini.clickcontrol.value == "disable")
                openwin.focus();
        }
    </script>

    <script language="JavaScript" type="text/JavaScript">
        <!--
        function MM_reloadPage(init) {  //reloads the window if Nav4 resized
            if (init == true) with (navigator) {
                if ((appName == "Netscape") && (parseInt(appVersion) == 4)) {
                    document.MM_pgW = innerWidth;
                    document.MM_pgH = innerHeight;
                    onresize = MM_reloadPage;
                }
            }
            else if (innerWidth != document.MM_pgW || innerHeight != document.MM_pgH) location.reload();
        }

        MM_reloadPage(true);

        function MM_jumpMenu(targ, selObj, restore) { //v3.0
            eval(targ + ".location='" + selObj.options[selObj.selectedIndex].value + "'");
            if (restore) selObj.selectedIndex = 0;
        }

        //-->
    </script>

</head>

<body bgcolor="#FFFFFF" text="#242424" leftmargin=0 topmargin=15 marginwidth=0 marginheight=0 bottommargin=0
      rightmargin=0 onload="javascript:enable_click()" onFocus="javascript:focus_control()">
<center>
    <form name=ini method=post action="/plugin/shop/INIrepay" onSubmit="return repay()">

        <table width="632" border="0" cellspacing="0" cellpadding="0">
            <tr>
                <td height="85" background="img/card.gif" style="padding:0 0 0 64">
                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                        <tr>
                            <td width="3%" valign="top"><img src="img/title_01.gif" width="8" height="27" vspace="5">
                            </td>
                            <td width="97%" height="40" class="pl_03"><font color="#FFFFFF"><b>부분취소 요청</b></font></td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr>
                <td align="center" bgcolor="6095BC">
                    <table width="620" border="0" cellspacing="0" cellpadding="0">
                        <tr>
                            <td bgcolor="#FFFFFF" style="padding:8 0 0 56">
                                <br>
                                <table width="510" border="0" cellspacing="0" cellpadding="0">
                                    <tr>
                                        <td width="7"><img src="img/life.gif" width="7" height="30"></td>
                                        <td background="img/center.gif"><img src="img/icon03.gif" width="12"
                                                                             height="10">
                                            <b>정보를 기입하신 후 결제버튼을 눌러주십시오.</b></td>
                                        <td width="8"><img src="img/right.gif" width="8" height="30"></td>
                                    </tr>
                                </table>
                                <br>
                                <table width="510" border="0" cellspacing="0" cellpadding="0">
                                    <tr>
                                        <td width="510" colspan="2" style="padding:0 0 0 23">
                                            <table width="470" border="0" cellspacing="0" cellpadding="0">
                                                <tr>
                                                    <td width="18" align="center"><img src="img/icon02.gif" width="7"
                                                                                       height="7"></td>
                                                    <td width="177" height="26">원거래번호</td>
                                                    <td width="280"><input type=text name=oldtid size=42 maxlength=40
                                                                           value=""></td>
                                                </tr>
                                                <tr>
                                                    <td height="1" colspan="3" align="center"
                                                        background="img/line.gif"></td>
                                                </tr>
                                                <tr>
                                                    <td width="18" align="center"><img src="img/icon02.gif" width="7"
                                                                                       height="7"></td>
                                                    <td width="109" height="25">취소할 금액</td>
                                                    <td width="343"><input type=text name=price size=20 value="10"></td>
                                                </tr>
                                                <tr>
                                                    <td height="1" colspan="3" align="center"
                                                        background="img/line.gif"></td>
                                                </tr>
                                                <tr>
                                                    <td width="18" align="center"><img src="img/icon02.gif" width="7"
                                                                                       height="7"></td>
                                                    <td width="109" height="25">승인요청 금액</td>
                                                    <td width="343"><input type=text name=confirm_price size=20
                                                                           value=""><b><font color=red> = [이전승인금액 - 취소할
                                                                금액]</font></b></td>
                                                </tr>
                                                <tr>
                                                    <td height="1" colspan="3" align="center"
                                                        background="img/line.gif"></td>
                                                </tr>
                                                <tr>
                                                    <td width="18" align="center"><img src="img/icon02.gif" width="7"
                                                                                       height="7"></td>
                                                    <td width="109" height="25">전 자 우 편</td>
                                                    <td width="343"><input type=text name=buyeremail size=20
                                                                           value="jiho8912@naver.com"></td>
                                                </tr>
                                                <tr>
                                                    <td height="1" colspan="3" align="center"
                                                        background="img/line.gif"></td>
                                                </tr>
                                                <tr>
                                                    <td height="1" colspan="3" align="center"
                                                        background="img/line.gif"></td>
                                                </tr>
                                                <tr>
                                                    <td width="18" align="center"><img src="img/icon02.gif" width="7"
                                                                                       height="7"></td>
                                                    <td width="109" height="25">부가세(Tax)</td>
                                                    <td width="343"><input type=text name=tax size=12 maxlength=12></td>
                                                </tr>
                                                <tr>
                                                    <td height="1" colspan="3" align="center"
                                                        background="img/line.gif"></td>
                                                </tr>
                                                <tr>
                                                    <td width="18" align="center"><img src="img/icon02.gif" width="7"
                                                                                       height="7"></td>
                                                    <td width="109" height="25">비과세<br>(Tax free)</td>
                                                    <td width="343"><input type=text name=taxfree size=12 maxlength=12>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td height="1" colspan="3" align="center"
                                                        background="img/line.gif"></td>
                                                </tr>
                                                <tr valign="bottom">
                                                    <td height="40" colspan="3" align="center"><input type=image
                                                                                                      src="img/button_03.gif"
                                                                                                      width="63"
                                                                                                      height="25"></td>
                                                </tr>
                                                <tr valign="bottom">
                                                    <td height="45" colspan="3">전자우편과 이동전화번호를 입력받는 것은 고객님의 결제성공 내역을
                                                        E-MAIL 또는 SMS 로
                                                        알려드리기 위함이오니 반드시 기입하시기 바랍니다.
                                                    </td>
                                                </tr>
                                            </table>
                                        </td>
                                    </tr>
                                </table>
                                <br>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr>
                <td><img src="img/bottom01.gif" width="632" height="13"></td>
            </tr>
        </table>
</center>

<input type=hidden name=mid value="INIpayTest">

<!--  수정 금지 -->
<input type=hidden name=clickcontrol value="">
<input type=hidden name=currency value="WON">

</form>
</body>
</html>
