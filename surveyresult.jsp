<%@ page import="java.util.*" %>
<%@ page import="java.text.SimpleDateFormat"%>
<%@page import="net.sf.json.JSONObject"%>
<%@page import="net.sf.json.JSONArray"%>
<%@page import="com.enjar.system.SystemUtil"%>
<%@page import="java.io.InputStreamReader"%>
<%@page import="java.io.BufferedReader"%>
<%@page import="java.io.InputStream"%>
<%@page import="org.apache.commons.httpclient.SimpleHttpConnectionManager"%>
<%@page import="java.io.IOException"%>
<%@page import="java.net.URLEncoder"%>
<%@page import="org.apache.commons.httpclient.HttpStatus"%>
<%@page import="org.apache.commons.httpclient.methods.GetMethod"%>
<%@page import="org.apache.commons.httpclient.HttpClient"%>
<%@page import="org.apache.commons.httpclient.HttpException"%>
<%@page import="com.enjar.system.SystemUtil"%>
<%@page import="com.enjar.system.LoginUtil"%>
<%@page import="com.enjar.system.util.SpringUtil"%>
<%@page import="com.xsx.val.Customer"%>
<%@page import="java.sql.PreparedStatement" %>
<%@page import="java.sql.Connection" %>
<%@page import="java.sql.SQLException"%>
<%@page import="javax.sql.DataSource"%>
<%@page import="java.sql.ResultSet"%>
<%@ page language="java" contentType="text/html; charset=UTF-8" pageEncoding="UTF-8"%>

<%
JSONArray surveyList = new JSONArray();
JSONObject jsonObject = new JSONObject();
Customer c = LoginUtil.getLoginCustomer(request);
String surveyURL = "https://www.taaze.tw/sendQnNo.html";
String masNo = request.getParameter("masNo")!=null?URLEncoder.encode(request.getParameter("masNo").toString(),"UTF-8"):"";
String ticketNum = request.getParameter("ticketNum")!=null?URLEncoder.encode(request.getParameter("ticketNum").toString(),"UTF-8"):"";
String qnNo = request.getParameter("qnNo")!=null?URLEncoder.encode(request.getParameter("qnNo").toString(),"UTF-8"):"";
String CUST_ID = request.getParameter("CUST_ID")!=null?request.getParameter("CUST_ID").toString():c.getCustId();
String CUST_NM = request.getParameter("CUST_NM")!=null?request.getParameter("CUST_NM").toString():c.getNickName();
String CUST_MAIL = request.getParameter("CUST_MAIL")!=null?request.getParameter("CUST_MAIL").toString():c.getMailMain();
String ACT_NO = request.getParameter("ACT_NO")!=null?URLEncoder.encode(request.getParameter("ACT_NO").toString(),"UTF-8"):"QA201911001";
String QN_STR_TIME = request.getParameter ("QN_STR_TIME" )!=null?URLEncoder.encode(request.getParameter("QN_STR_TIME").toString(),"UTF-8"):"";
String QN_END_TIME = request.getParameter ("QN_END_TIME" )!=null?URLEncoder.encode(request.getParameter("QN_END_TIME").toString(),"UTF-8"):"";
String ANS_2TIME = request.getParameter("ANS_2TIME")!=null?URLEncoder.encode(request.getParameter("ANS_2TIME").toString(),"UTF-8"):"";
String ANS_3TIME = request.getParameter("ANS_3TIME")!=null?URLEncoder.encode(request.getParameter("ANS_3TIME").toString(),"UTF-8"):"";
String ANS_4TIME = request.getParameter("ANS_4TIME")!=null?URLEncoder.encode(request.getParameter("ANS_4TIME").toString(),"UTF-8"):"";
String RCV_NM = request.getParameter("RCV_NM")!=null?request.getParameter("RCV_NM").toString():c.getNickName();
String RCV_MAIL = request.getParameter("RCV_MAIL")!=null?request.getParameter("RCV_MAIL").toString():c.getMailMain();
String Gift1 = request.getParameter("Gift1")!=null?URLEncoder.encode(request.getParameter("Gift1").toString(),"UTF-8"):"";
String Gift2 = request.getParameter("Gift2")!=null?URLEncoder.encode(request.getParameter("Gift2").toString(),"UTF-8"):"";
String AnswerQ1 = request.getParameter("AnswerQ1")!=null?URLEncoder.encode(request.getParameter("AnswerQ1").toString(),"UTF-8"):"";
String AnswerQ2 = request.getParameter("AnswerQ2")!=null?URLEncoder.encode(request.getParameter("AnswerQ2").toString(),"UTF-8"):"";
String AnswerQ3 = request.getParameter("AnswerQ3")!=null?URLEncoder.encode(request.getParameter("AnswerQ3").toString(),"UTF-8"):"";
String AnswerQ4 = request.getParameter("AnswerQ4")!=null?URLEncoder.encode(request.getParameter("AnswerQ4").toString(),"UTF-8"):"";
int error_code = 100; 
String GIFT_NM ="";
surveyURL += "?";
surveyURL += "o="+masNo;
surveyURL += "&v="+qnNo;
//surveyURL += "&ACT_NO=QA201911001&CUST_ID="+CUST_ID;
//surveyURL += "&CUST_NM="+CUST_NM;
//surveyURL += "&CUST_MAIL="+CUST_MAIL;
//surveyURL += "&AnswerQ1="+AnswerQ1;
//surveyURL += "&AnswerQ2="+AnswerQ2;
//surveyURL += "&AnswerQ3="+AnswerQ3;
//surveyURL += "&AnswerQ4="+AnswerQ4;
//surveyURL += "&RCV_NM="+RCV_NM;
//surveyURL += "&RCV_MAIL="+RCV_MAIL;
//surveyURL += "&Gift1=Y";
////+Gift1;
//surveyURL += "&Gift2=Y";
////+Gift2;
//surveyURL += "&QN_STR_TIME="+QN_STR_TIME;
//surveyURL += "&QN_END_TIME="+QN_END_TIME;
//surveyURL += "&ANS_2TIME="+ANS_2TIME;
//surveyURL += "&ANS_3TIME="+ANS_3TIME;
//surveyURL += "&ANS_4TIME="+ANS_4TIME;


//QN_STR_TIME="+starttime1+"ANS_2TIME="+starttime2+"ANS_3TIME="+starttime3+"ANS_4TIME="+starttime4+"&QN_END_TIME="+endtime;

HttpClient client = new HttpClient();
//GetMethod post = new GetMethod(surveyURL);
client.getHttpConnectionManager().getParams().setConnectionTimeout(15000);
client.getHttpConnectionManager().getParams().setSoTimeout(15000);
String reValue = "";

SimpleDateFormat sdf=new SimpleDateFormat("yyyy/MM/dd HH:mm:ss");
if(QN_STR_TIME!=null&&!QN_STR_TIME.equals("")){
QN_STR_TIME = sdf.format(new Date(Long.parseLong(String.valueOf(QN_STR_TIME))));
}
//Date dateS = java.sql.Date.valueOf(QN_STR_TIME);
if(QN_END_TIME!=null&&!QN_END_TIME.equals("")){
QN_END_TIME = sdf.format(new Date(Long.parseLong(String.valueOf(QN_END_TIME))));
}
//Date dateE = java.sql.Date.valueOf(QN_END_TIME);
if(ANS_2TIME!=null&&!ANS_2TIME.equals("")){
ANS_2TIME = sdf.format(new Date(Long.parseLong(String.valueOf(ANS_2TIME))));
}
//Date date2 = java.sql.Date.valueOf(ANS_2TIME);
if(ANS_3TIME!=null&&!ANS_3TIME.equals("")){
ANS_3TIME = sdf.format(new Date(Long.parseLong(String.valueOf(ANS_3TIME))));
}
//Date date3 = java.sql.Date.valueOf(ANS_3TIME);
if(ANS_4TIME!=null&&!ANS_4TIME.equals("")){
ANS_4TIME = sdf.format(new Date(Long.parseLong(String.valueOf(ANS_4TIME))));
}
//Date date4 = java.sql.Date.valueOf(ANS_4TIME);
//String Datenow = sdf.format(new java.util.Date());
Connection conn = null;
ResultSet rs = null;
PreparedStatement pstmt = null;
String excuteStr = "";
DataSource ds=(DataSource)SpringUtil.getSpringBeanById(this, "datasource");
conn = ds.getConnection();
conn.setAutoCommit(false);
String queryStr = "";
int lesson_count = 0;
try
{
		queryStr = "select GIFT_RM_QTY from QN_GIFT_CTN where GIFT_NO='GT20191104'";
		pstmt = conn.prepareStatement(queryStr);
		rs = pstmt.executeQuery();
		if(rs.next()) {
			lesson_count = rs.getInt("GIFT_RM_QTY");
		}
		rs.close();

//											1		2		3		4		5		6			7			8			9		10		
		excuteStr = "INSERT INTO QN_REC_MAIN(SC_NO,ACT_NO,TAKE_TIME,CUST_ID,CUST_NM,CUST_MAIL,QN_STR_TIME,QN_END_TIME,CRT_USER,CRT_TIME)values(?,?,TO_DATE('"+QN_STR_TIME+"', 'yyyy/mm/dd hh24:mi:ss'),?,?,?,TO_DATE('"+QN_STR_TIME+"', 'yyyy/mm/dd hh24:mi:ss'),TO_DATE('"+QN_END_TIME+"', 'yyyy/mm/dd hh24:mi:ss'),?,sysdate)";
		pstmt = conn.prepareStatement(excuteStr);
		pstmt.setString(1,masNo);
		pstmt.setString(2,ACT_NO);
		//pstmt.setString(3,QN_STR_TIME);
		pstmt.setString(3,CUST_ID);
		pstmt.setString(4,CUST_NM);
		pstmt.setString(5,CUST_MAIL);
		//pstmt.setString(7,QN_STR_TIME);
		//pstmt.setString(8,QN_END_TIME);
		pstmt.setString(6,CUST_NM);
		pstmt.executeUpdate();
		conn.commit();
		//										1		2		3		4		5		6			7
		excuteStr = "INSERT INTO QN_REC_DETAIL(ACT_NO,TAKE_TIME,CUST_ID,QST_NO,ANS_CNT,ANS_STR_TIME,ANS_END_TIME)values('"+ACT_NO+"',TO_DATE('"+QN_STR_TIME+"', 'yyyy/mm/dd hh24:mi:ss'),'"+CUST_ID+"','1','"+AnswerQ1+"',TO_DATE('"+QN_STR_TIME+"', 'yyyy/mm/dd hh24:mi:ss'),TO_DATE('"+ANS_2TIME+"', 'yyyy/mm/dd hh24:mi:ss'))";
		pstmt = conn.prepareStatement(excuteStr);
		pstmt.executeUpdate();
		conn.commit();
		excuteStr = "INSERT INTO QN_REC_DETAIL(ACT_NO,TAKE_TIME,CUST_ID,QST_NO,ANS_CNT,ANS_STR_TIME,ANS_END_TIME)values('"+ACT_NO+"',TO_DATE('"+QN_STR_TIME+"', 'yyyy/mm/dd hh24:mi:ss'),'"+CUST_ID+"','2','"+AnswerQ2+"',TO_DATE('"+ANS_2TIME+"', 'yyyy/mm/dd hh24:mi:ss'),TO_DATE('"+ANS_3TIME+"', 'yyyy/mm/dd hh24:mi:ss'))";
		pstmt = conn.prepareStatement(excuteStr);
		pstmt.executeUpdate();
		conn.commit();
		excuteStr = "INSERT INTO QN_REC_DETAIL(ACT_NO,TAKE_TIME,CUST_ID,QST_NO,ANS_CNT,ANS_STR_TIME,ANS_END_TIME)values('"+ACT_NO+"',TO_DATE('"+QN_STR_TIME+"', 'yyyy/mm/dd hh24:mi:ss'),'"+CUST_ID+"','3','"+AnswerQ3+"',TO_DATE('"+ANS_3TIME+"', 'yyyy/mm/dd hh24:mi:ss'),TO_DATE('"+ANS_4TIME+"', 'yyyy/mm/dd hh24:mi:ss'))";
		pstmt = conn.prepareStatement(excuteStr);
		pstmt.executeUpdate();
		conn.commit();
		if(QN_END_TIME!=null&&!QN_END_TIME.equals("")){
			excuteStr = "INSERT INTO QN_REC_DETAIL(ACT_NO,TAKE_TIME,CUST_ID,QST_NO,ANS_CNT,ANS_STR_TIME,ANS_END_TIME)values('"+ACT_NO+"',TO_DATE('"+QN_STR_TIME+"', 'yyyy/mm/dd hh24:mi:ss'),'"+CUST_ID+"','4','"+AnswerQ4+"',TO_DATE('"+ANS_4TIME+"', 'yyyy/mm/dd hh24:mi:ss'),TO_DATE('"+QN_END_TIME+"', 'yyyy/mm/dd hh24:mi:ss'))";
			pstmt = conn.prepareStatement(excuteStr);
			pstmt.executeUpdate();
			conn.commit();
		}else{
			excuteStr = "INSERT INTO QN_REC_DETAIL(ACT_NO,TAKE_TIME,CUST_ID,QST_NO,ANS_CNT,ANS_STR_TIME,ANS_END_TIME)values('"+ACT_NO+"',TO_DATE('"+QN_STR_TIME+"', 'yyyy/mm/dd hh24:mi:ss'),'"+CUST_ID+"','4','"+AnswerQ4+"',TO_DATE('"+ANS_4TIME+"', 'yyyy/mm/dd hh24:mi:ss'),sysdate)";
			pstmt = conn.prepareStatement(excuteStr);
			pstmt.executeUpdate();
			conn.commit();
		}
		if(AnswerQ4.equals("Yes")||AnswerQ4.equals("No")){
			GIFT_NM= "回饋金5點";
			excuteStr = "INSERT INTO QN_REC_GIFT(ACT_NO,TAKE_TIME,CUST_ID,QST_NO,GIFT_NO,GIFT_NM,QTY,RCV_NM,RCV_MAIL)values('"+ACT_NO+"',TO_DATE('"+QN_STR_TIME+"', 'yyyy/mm/dd hh24:mi:ss'),'"+CUST_ID+"','0','GT20191101','"+GIFT_NM+"','1','"+CUST_NM+"','"+CUST_MAIL+"')";
			pstmt = conn.prepareStatement(excuteStr);
			pstmt.executeUpdate();
			conn.commit();
			if(!ticketNum.equals("0")){
				GIFT_NM= "島內散步100元抵用券";
				excuteStr = "INSERT INTO QN_REC_GIFT(ACT_NO,TAKE_TIME,CUST_ID,QST_NO,GIFT_NO,GIFT_NM,QTY,GIFT_SN,RCV_NM,RCV_MAIL)values('"+ACT_NO+"',TO_DATE('"+QN_STR_TIME+"', 'yyyy/mm/dd hh24:mi:ss'),'"+CUST_ID+"','0','GT20191102','"+GIFT_NM+"','1','2019TAAZETRIP','"+CUST_NM+"','"+CUST_MAIL+"')";
				pstmt = conn.prepareStatement(excuteStr);
				pstmt.executeUpdate();
				conn.commit();
			}
			if(RCV_MAIL!=null){
				if(!RCV_MAIL.equals(CUST_MAIL)){
					GIFT_NM= "給朋友的e-coupon";
					excuteStr = "INSERT INTO QN_REC_GIFT(ACT_NO,TAKE_TIME,CUST_ID,QST_NO,GIFT_NO,GIFT_NM,QTY,RCV_NM,RCV_MAIL)values('"+ACT_NO+"',TO_DATE('"+QN_STR_TIME+"', 'yyyy/mm/dd hh24:mi:ss'),'"+CUST_ID+"','0','GT20191103','"+GIFT_NM+"','1','"+RCV_NM+"','"+RCV_MAIL+"')";
					pstmt = conn.prepareStatement(excuteStr);
					pstmt.executeUpdate();
					conn.commit();
				}else{
					GIFT_NM= "給朋友的e-coupon";
					excuteStr = "INSERT INTO QN_REC_GIFT(ACT_NO,TAKE_TIME,CUST_ID,QST_NO,GIFT_NO,GIFT_NM,QTY,RCV_NM,RCV_MAIL)values('"+ACT_NO+"',TO_DATE('"+QN_STR_TIME+"', 'yyyy/mm/dd hh24:mi:ss'),'"+CUST_ID+"','0','GT20191103','"+GIFT_NM+"','1','"+RCV_NM+"','')";
					pstmt = conn.prepareStatement(excuteStr);
					pstmt.executeUpdate();
					conn.commit();
				}
			}
			if(lesson_count>0){
				GIFT_NM= "加碼贈線上課程";
				excuteStr = "INSERT INTO QN_REC_GIFT(ACT_NO,TAKE_TIME,CUST_ID,QST_NO,GIFT_NO,GIFT_NM,QTY,RCV_NM,RCV_MAIL)values('"+ACT_NO+"',TO_DATE('"+QN_STR_TIME+"', 'yyyy/mm/dd hh24:mi:ss'),'"+CUST_ID+"','0','GT20191104','"+GIFT_NM+"','1','"+CUST_NM+"','"+CUST_MAIL+"')";
				pstmt = conn.prepareStatement(excuteStr);
				pstmt.executeUpdate();
				conn.commit();
			}
		//int statusCode = client.executeMethod(post);
		}
} catch (Exception ex)
{
	//error_code= 113;
	//out.print("3:"+ex+"<br>");
}finally {
		jsonObject.put("error_code",error_code);
		//response.setContentType("application/json");
		//response.getWriter().write(jsonObject.toString());
		conn.close();
	}
//out.print(excuteStr);
//out.print("???"+QN_END_TIME);
//out.print("<br>why<br>");
//out.print(surveyList.toString()+"<br>");
//out.print(reValue+"here");
%>