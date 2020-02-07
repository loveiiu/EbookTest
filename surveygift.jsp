<%@ page language="java" contentType="text/html; charset=UTF-8"
pageEncoding="UTF-8"%>
<link rel="stylesheet" type="text/css" href="/new_ec/rwd/include/css/survey.css" />
<div id='G2'class='foriframe'>
<div id='close' onclick='closeiframe()'>×</div>
<div id='machine2'></div>
<div id='btn_home' style=''>
<div id='startGame'></div>
</div>
</div>
<div id='gift_home' class='foriframe'>
<div id='close' onclick='closeiframe()'>×</div>
<div id='gift_text'>謝謝您的回覆，讀冊生活已收到<br>
點擊收下，領取你的專屬好禮</div>
<div id='gift'>
<img src='/new_ec/rwd/include/images/images_for_survey/pic/pic_giftpage_1.png' style='max-width:160px;'>
<div id='giftframe'>回饋金 5 元<div id='gift_contnent' class='coin'>快到會員中心，<br>確認專屬於你的獎項吧。</div><div class='takegift' id='coin'></div></div>
</div>
<hr id='hr' style=''>
<div id='gift'>
<img src='/new_ec/rwd/include/images/images_for_survey/pic/pic_giftpage_2.png' style='max-width:160px;'>
<div id='giftframe'>島內散步/城市散步<br> 100 元抵用券<div id='gift_contnent' class='ticket'>快到會員中心，<br>確認專屬於你的獎項吧。</div><div class='takegift' id='ticket' onclick='getticket()' style='margin-top:-20px;'></div></div>
</div>
<hr id='hr' style=''>
<div id='gift'>
<img src='/new_ec/rwd/include/images/images_for_survey/pic/pic_giftpage3.png' style='max-width:160px;'>
<div id='giftframe' class='coupon' >分享e-coupon<br>給好友<div class='takegift' id='coupon' onclick='sendcoupon()' style='margin-top:-20px;'></div></div>
<div id='giftframe' class='email' data-ride='carousel' style='display:none; height:94px;padding-top:30px;'>
<div style='display:flex;'>From<input id="" style="margin-left:8px;border: 1px solid #979797;width:235px;height:30px;" placeholder="輸入寄件人的暱稱" type="" class="" value="" autocomplete="off"></div>
<div style='display:flex;margin-top:10px;'>to<input id="" style="margin-left:31px;border: 1px solid #979797;width:235px;height:30px;" placeholder="Email" type="" class="" value="" autocomplete="off"></div>
<div class='sendgift' id='coupon' onclick='sendcouponprocess()' style='margin-top:10px;'></div>
</div>
<div id='giftframe' class='couponsend' style='display:none;font-size:14.8px'>你分享e-coupon已經<br>寄給你的親朋好友<a href='#thankpage2'><div class='takegiftcomplete' id='coupon' onclick='sendcouponcomplete()' style='margin-top:-20px;'></div></a></div>
</div>
</div>
<!--等序號計算法出來之後這頁要加if else-->
<div id='thankpage' class='foriframe'>
<div id='close' onclick='closeiframe()'>×</div>
<!--if 6000名之前-->
<div id='divflex' style=''>
<div id='thank_text'>
恭喜你！<br>
第??名回覆問卷<br>
驚喜加碼送市值＄xxxx元線上課程乙堂<br>
快到會員中心，查看專屬於你的超值好禮吧！<br>
</div>
<div id='thankpic1'></div>
</div>
</div>
<div id='thankpage2' class='foriframe'>
<div id='close' onclick='closeiframe()'>×</div>
<!--else-->
<div id='divflex' style=''>
<div id='thank_final' style=''>
謝謝您的回覆，讀冊已收到
</div>
<div id='thankpic2'></div>
</div>
</div>
<!--等序號計算法出來之後這頁要加if else-->
<%@ include file="/new_ec/rwd/include/js_index.jsp" %>
<script type="text/javascript" src="/new_ec/rwd/include/js/survey.js"></script>