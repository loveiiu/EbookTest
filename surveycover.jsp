<%@page import="com.taaze.system.util.SecureTool"%>
<%@page import="org.apache.commons.logging.LogFactory"%>
<%@page import="org.apache.commons.logging.Log"%>
<%@page import="org.apache.commons.lang.StringUtils" %>
<%@page import="com.enjar.system.Global.CustomerLoginStatus"%>
<%@page import="com.xsx.customer.service.CustomerService"%>
<%@page import="com.xsx.manage.service.VirtualCurrencyService" %>
<%@page import="com.xsx.manage.service.impl.VirtualCurrencyServiceImp" %>
<%@page import="com.xsx.manage.service.MailRecordService" %>
<%@page import="com.xsx.manage.service.impl.MailRecordServiceImp" %>
<%@page import="com.enjar.system.util.DateUtil" %>
<%@page import="com.enjar.system.util.SpringUtil"%>
<%@page import="com.enjar.system.EnjarUtil" %>
<%@page import="com.enjar.system.LoginUtil"%>
<%@page import="com.enjar.system.*"%>
<%@page import="com.xsx.dao.SystemDAO"%>
<%@page import="com.xsx.val.MailRecord" %>
<%@page import="com.xsx.val.impl.MailRecordImp" %>
<%@page import="java.net.URLEncoder"%>
<%@page import="java.sql.SQLException"%>
<%@page import="javax.sql.DataSource"%>
<%@page import="java.sql.ResultSet"%>
<%@page import="java.text.DateFormat"%>
<%@page import="java.text.SimpleDateFormat" %>                           
<%@page import="java.sql.PreparedStatement" %>
<%@page import="java.sql.Connection" %>
<%@page import="com.xsx.val.Customer"%>
<%@page import="java.util.Random" %>
<%@page import="java.math.BigDecimal" %>
<%@page import="com.xsx.val.ECouponItem" %>
<%@page import="com.xsx.val.ECouponMas" %>
<%@page import="java.io.*" %>
<%@page import="java.util.*" %>
<%@page import="net.sf.json.JSONObject" %>
<%@page import="net.sf.json.JSONArray" %>
<%@ page language="java" contentType="text/html; charset=UTF-8"
pageEncoding="UTF-8"%>
<link rel="stylesheet" type="text/css" href="/new_ec/rwd/include/css/survey.css?v=46" />
<%
Customer cc = LoginUtil.getLoginCustomer(request);
String masNo=request.getParameter("o");//单号
int ticketNum=1;
if(cc==null || StringUtils.isBlank(masNo) || masNo.trim().length()!=14){//单号非法 或者不是会员
	//要么直接关闭当前页,或者给出其它提醒
%>
<script type="text/javascript">
	window.parent.$(".reveal-modal-bg").hide(); 	
	window.parent.$("#qn").hide();
</script>
<%
	return;
}
String qnNo = SystemUtil.md5Hex(masNo.substring(3,14));
SystemDAO systemDAO = (SystemDAO) SpringUtil.getSpringBeanById(this, "SystemDAO");
//验证会员是否已有 问卷过了
List ticketCount=systemDAO.queryBySqlCommand("select GIFT_RM_QTY from QN_GIFT_CTN where GIFT_NO='GT20191102' ", new String[]{});
if(ticketCount!=null && ticketCount.size()==1){
ticketNum=Integer.valueOf(ticketCount.get(0).toString());
}
List sizeList=systemDAO.queryBySqlCommand("SELECT COUNT(*) FROM QN_REC_GIFT WHERE CUST_ID=? ", new String[]{cc.getCustId()});
if(sizeList!=null && sizeList.size()==1){
	int size=Integer.valueOf(sizeList.get(0).toString());
	if(size>0){
		//已问卷过了,要么直接关闭当前页,或者给出其它提醒
%>
<script type="text/javascript">
	window.parent.$(".reveal-modal-bg").hide(); 	
	window.parent.$("#qn").hide();
</script>
<%
		return;
	}
}
%>
<head>
<input id="hideMasNo" type="hidden" value='<%=request.getParameter("o") %>' />
<input id="hideQnNo" type="hidden" value='<%=qnNo%>' />	
<input id="hideLogin" type="hidden" value='<%=LoginUtil.isLoginCustomer(request) && cc!=null?"true":"false" %>' />	
<input id="hideCustId" type="hidden" value='<%=LoginUtil.isLoginCustomer(request) && cc!=null?cc.getCustId():"" %>' />
<input id="hideCustNm" type="hidden" value='<%=LoginUtil.isLoginCustomer(request) && cc!=null?cc.getNickName():"" %>' />
<input id="hideMailMain" type="hidden" value='<%=LoginUtil.isLoginCustomer(request) && cc!=null?cc.getMailMain():"" %>' />
<input id="AnswerQ1" type="hidden" value="" />
<input id="AnswerQ2" type="hidden" value="" />
<input id="AnswerQ3" type="hidden" value="" />
<input id="AnswerQ4" type="hidden" value="" />
<input id="Gift1" type="hidden" value="" />
<input id="Gift2" type="hidden" value="" />
<input id="ticketNum" type="hidden" value='<%=ticketNum%>' />
<input id="starttime1" type="hidden" value="" />
<input id="starttime2" type="hidden" value="" />
<input id="starttime3" type="hidden" value="" />
<input id="starttime4" type="hidden" value="" />
<input id="endtime" type="hidden" value="" />
</head>
<body>
<div id='cover' class='foriframe'>
<div id='close' onclick='closeiframe()'></div>
<div id ='surveycover'></div>
<div id='surveyrule'></div>
<div id ='surveycontnent'>
<ol>
<li>按GO前往測試。</li>
<li>完成問卷後，即可進行活動抽獎，每人每個帳號僅有一次抽獎機會。</li>
<li>獎品內容有有回饋金5點、$20元E-coupon、島內散步100元抵用劵（數量有限，送完為止）。</li>
<li>前6000名完成測驗者，加贈免費體驗線上課程乙堂（限量贈品，送完為止）。</li>
<li>活動期間所獲得之回饋金、折價券、兌換券，以會員E-mail通知，請依規定使用，逾期不補發。</li>
</ol>
</div>
<a href='#Q1'><div id='surveygo'style='height:100px;width:100px;'onclick='starttime1()'></div></a>
</div>
<div id='Q1' class='foriframe'>
<div id='close' onclick='closeiframe()'></div>
<div id='surveyQ1'></div>
<div id='select_home'>
<div class="AnswerQ1" id="radio" onclick="Q1Y()"></div> 知道 
<div id='none'></div>
<div class="AnswerQ1" id="radio" onclick="Q1N()"></div> 不知道
</div>
<div id='progressbarQ1'></div>
</div>
<div id='A1' class='foriframe'>
<div id='close' onclick='closeiframe()'></div>
<div id='surveyA1'></div>
<div id='btn_home' style=''>
<a id='Q1link' href='#Q2'><div id='nextQuestion'onclick='starttime2()'></div></a>
</div>
<div id='progressbarA1'></div>
</div>
<div id='Q2' class='foriframe'>
<div id='close' onclick='closeiframe()'></div>
<div id='surveyQ2'></div>
<div id='select_home'>
<div class="AnswerQ2" id="radio" onclick="Q2Y()"></div> 知道
<div id='none'></div>            
<div class="AnswerQ2" id="radio" onclick="Q2N()"></div> 不知道
</div>
<div id='progressbarQ2'></div>
</div>
<div id='A2' class='foriframe'>
<div id='close' onclick='closeiframe()'></div>
<div id='surveyA2'></div>
<div id='btn_home'>
<a href='#A1'><div id='lastQuestion'></div></a>
<div id='none' style='width:10px;'></div>
<a id='Q2link' href='#Q3'><div id='nextQuestion'onclick='starttime3()'></div></a>
</div>
<div id='progressbarA2'></div>
</div>
<div id='Q3' class='foriframe'>
<div id='close' onclick='closeiframe()'></div>
<div id='surveyQ3'></div>
<div id='select_home'>
<div class="AnswerQ3" id="radio" onclick="Q3Y()"></div> 會
<div id='none' style='width:100px;'></div> 
<div class="AnswerQ3" id="radio" onclick="Q3N()"></div> 不會
</div>                           
<div id='progressbarQ3'></div>   
</div>
<div id='A3' class='foriframe'>
<div id='close' onclick='closeiframe()'></div>
<div id='surveyA3'></div>
<div id='btn_home'>
<a href='#A2'><div id='lastQuestion'></div></a>
<div id='none' style='width:10px;'></div>
<a id='Q3link' href='#Q4'><div id='nextQuestion'onclick='starttime4()'></div></a>
</div>
<div id='progressbarA3'></div>
</div>
<div id='Q4' class='foriframe'>
<div id='close' onclick='closeiframe()'></div>
<div id='surveyQ4'></div>
<div id='select_home'>
<div class="AnswerQ4" id="radio" onclick="Q4Y()"></div> 會有警覺
<div id='none' style=''></div>
<div class="AnswerQ4" id="radio" onclick="Q4N()"></div> 不會有警覺
</div>
<div id='progressbarQ4'></div>
</div>
<div id='A4' class='foriframe'>
<div id='close' onclick='closeiframe()'></div>
<div id='surveyA4'>
<div id='time'>
<?xml version="1.0" encoding="UTF-8" standalone="no"?><svg xmlns:svg="http://www.w3.org/2000/svg" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.0" width="100px" height="100px" viewBox="0 0 128 128" xml:space="preserve"><g><circle cx="16" cy="64" r="16" fill="#e3007f" fill-opacity="1"/><circle cx="16" cy="64" r="14.344" fill="#e3007f" fill-opacity="1" transform="rotate(45 64 64)"/><circle cx="16" cy="64" r="12.531" fill="#e3007f" fill-opacity="1" transform="rotate(90 64 64)"/><circle cx="16" cy="64" r="10.75" fill="#e3007f" fill-opacity="1" transform="rotate(135 64 64)"/><circle cx="16" cy="64" r="10.063" fill="#e3007f" fill-opacity="1" transform="rotate(180 64 64)"/><circle cx="16" cy="64" r="8.063" fill="#e3007f" fill-opacity="1" transform="rotate(225 64 64)"/><circle cx="16" cy="64" r="6.438" fill="#e3007f" fill-opacity="1" transform="rotate(270 64 64)"/><circle cx="16" cy="64" r="5.375" fill="#e3007f" fill-opacity="1" transform="rotate(315 64 64)"/><animateTransform attributeName="transform" type="rotate" values="0 64 64;315 64 64;270 64 64;225 64 64;180 64 64;135 64 64;90 64 64;45 64 64" calcMode="discrete" dur="720ms" repeatCount="indefinite"></animateTransform></g></svg>
<div id='sec'></div>
</div>
</div>
<div style='height:20px;'></div>
<div id='progressbarA4'></div> 
</div>
<div id='G1' class='foriframe'>
<div id='close' onclick='closeiframe()'></div>
<div id='join'>
&nbsp;&nbsp;完成問卷，參加抽獎吧！</div>
<div id='machine1'></div>
<div id='btn_home'>
<!--<a href='#A3'><div id='lastQuestion' ></div></a>-->
<div id='none' style='width:10px;'></div>
<a href='#G2'><div id='joinGame'onclick='endtime()'></div></a>
</div>
</div>
<div id='progressbarA4'></div>
<div id='G2'class='foriframe'>
<div id='close' onclick='closeiframe()'></div>
<div id='machineing'></div>
<div id='btn_home' style=''>
<!--<div id='startGame'></div>-->
</div>
</div>
<div id='gift_home' class='foriframe'>
<div id='close' onclick='closeiframe()'></div>
<div id='gift_text'>謝謝您的回覆，讀冊生活已收到。<br>
請點擊領取，並至【會員中心→訊息管理】查看您的專屬好禮！</div>
<div id='gift'>
<img src='/new_ec/rwd/include/images/images_for_survey/pic/pic_giftpage_1.png' style='max-width:160px;'>
<div id='giftframe'>回饋金 5 點<div id='gift_contnent' class='coin'>快到會員中心，<br>確認專屬於您的獎項吧。</div><div class='takegift' id='coin' onclick='getcoin()' value=''></div></div>
</div>
<hr id='hr' style=''>
<div id='gift'>
<%if(ticketNum==0){%>
	<img src='/new_ec/rwd/include/images/images_for_survey/pic/pic_giftpage_2end.png' style='max-width:160px;'>
<%}else{%>
	<img src='/new_ec/rwd/include/images/images_for_survey/pic/pic_giftpage_2.png' style='max-width:160px;'>
<%}%>
<div id='giftframe'>島內散步<br> 100 元抵用券<div id='gift_contnent' class='ticket'>快到會員中心，<br>確認專屬於您的獎項吧。</div><div class='takegift' id='ticket' onclick='getticket()' value='' style='margin-top:-20px;'></div></div>
</div>
<hr id='hr' style=''>
<div id='gift'>
<img src='/new_ec/rwd/include/images/images_for_survey/pic/pic_giftpage3.png' style='max-width:160px;'>
<div id='giftframe' class='coupon' >分享e-coupon<br>給好友<div class='takegift' id='coupon' onclick='sendcoupon()' style='margin-top:-20px;'></div></div>
<div id='giftframe' class='email' data-ride='carousel' style='height: 94px;'>
<div style='display:flex;'>From<input id="RCV_NM" style="" placeholder="輸入寄件人的暱稱" class="SEND_NM" name="SEND_NM"></div>
<div style='display:flex;margin-top:10px;'>to<input id="RCV_MAIL" style="" placeholder="Email"class="RCV_MAIL" name="RCV_MAIL"></div>
<div class='sendgift' id='coupon' onclick='sendcouponprocess()' style='margin-top:10px;'></div>
</div>
<div id='giftframe' class='couponsend' style='display:none;'>您分享e-coupon已經<br>寄給您的親朋好友<div class='takegiftcomplete' id='coupon' style=''></div></div>
</div>
<!--<a id='tofinal' href='#thankpage2'>-->
<hr id='hr' style=''>
<div id='closeGiftframe'><div id='closeGift'onclick='closeiframe()'></div></div>
<div id='showDiv'></div>
<!--</a>-->
</div>

<!--等序號計算法出來之後這頁要加if else
<div id='thankpage' class='foriframe'>
<div id='close' onclick='closeiframe()'></div>
<!--if 6000名之前
<div id='divflex' style=''>
<div id='thank_text'>
恭喜您！<br>
第??名回覆問卷<br>
驚喜加碼送市值＄xxxx元線上課程乙堂<br>
快到會員中心，查看專屬於您的超值好禮吧！<br>
</div>
<div id='thankpic1'></div>
</div>
</div>
<div id='thankpage2' class='foriframe'>
<div id='close' onclick='closeiframe()'></div>
<!--else
<div id='divflex' style=''>
<div id='thank_final' style=''>
謝謝您的回覆，讀冊已收到
</div>
<div id='thankpic2'></div>
</div>
</div>
<!--等序號計算法出來之後這頁要加if else-->
</body>
<%@ include file="/new_ec/rwd/include/js_index.jsp" %>
<script type="text/javascript" src="/new_ec/rwd/include/js/survey.js?v=36"></script>