<%@ page import="java.util.*" %>
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
String qnNo = request.getParameter("qnNo")!=null?URLEncoder.encode(request.getParameter("qnNo").toString(),"UTF-8"):"";
String CUST_ID = request.getParameter("CUST_ID")!=null?URLEncoder.encode(request.getParameter("CUST_ID").toString(),"UTF-8"):c.getCustId();
String CUST_NM = request.getParameter("CUST_NM")!=null?URLEncoder.encode(request.getParameter("CUST_NM").toString(),"UTF-8"):c.getNickName();
String CUST_MAIL = request.getParameter("CUST_MAIL")!=null?URLEncoder.encode(request.getParameter("CUST_MAIL").toString(),"UTF-8"):c.getMailMain();
String ACT_NO = request.getParameter("ACT_NO")!=null?URLEncoder.encode(request.getParameter("ACT_NO").toString(),"UTF-8"):"QA201911001";
String QN_STR_TIME = request.getParameter ("QN_STR_TIME" )!=null?URLEncoder.encode(request.getParameter("QN_STR_TIME").toString(),"UTF-8"):"";
String QN_END_TIME = request.getParameter ("QN_END_TIME" )!=null?URLEncoder.encode(request.getParameter("QN_END_TIME").toString(),"UTF-8"):"";
String ANS_2TIME = request.getParameter("ANS_2TIME")!=null?URLEncoder.encode(request.getParameter("ANS_2TIME").toString(),"UTF-8"):"";
String ANS_3TIME = request.getParameter("ANS_3TIME")!=null?URLEncoder.encode(request.getParameter("ANS_3TIME").toString(),"UTF-8"):"";
String ANS_4TIME = request.getParameter("ANS_4TIME")!=null?URLEncoder.encode(request.getParameter("ANS_4TIME").toString(),"UTF-8"):"";
String RCV_NM = request.getParameter("RCV_NM")!=null?URLEncoder.encode(request.getParameter("RCV_NM").toString(),"UTF-8"):c.getNickName();
String RCV_MAIL = request.getParameter("RCV_MAIL")!=null?URLEncoder.encode(request.getParameter("RCV_MAIL").toString(),"UTF-8"):c.getMailMain();
String Gift1 = request.getParameter("Gift1")!=null?URLEncoder.encode(request.getParameter("Gift1").toString(),"UTF-8"):"";
String Gift2 = request.getParameter("Gift2")!=null?URLEncoder.encode(request.getParameter("Gift2").toString(),"UTF-8"):"";
String AnswerQ1 = request.getParameter("AnswerQ1")!=null?URLEncoder.encode(request.getParameter("AnswerQ1").toString(),"UTF-8"):"";
String AnswerQ2 = request.getParameter("AnswerQ2")!=null?URLEncoder.encode(request.getParameter("AnswerQ2").toString(),"UTF-8"):"";
String AnswerQ3 = request.getParameter("AnswerQ3")!=null?URLEncoder.encode(request.getParameter("AnswerQ3").toString(),"UTF-8"):"";
String AnswerQ4 = request.getParameter("AnswerQ4")!=null?URLEncoder.encode(request.getParameter("AnswerQ4").toString(),"UTF-8"):"";
int error_code = 100; 

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
GetMethod post = new GetMethod(surveyURL);
client.getHttpConnectionManager().getParams().setConnectionTimeout(15000);
client.getHttpConnectionManager().getParams().setSoTimeout(15000);
String reValue = "";
try
{
	int statusCode = client.executeMethod(post);
	
	if (statusCode != HttpStatus.SC_OK)
	{
		// Method failed
		// post.getStatusLine();
	} else
	{
		//byte[] responseBody = post.getResponseBody();
		//dat = new String(responseBody);
		InputStream resStream = post.getResponseBodyAsStream();
		BufferedReader br = new BufferedReader(new InputStreamReader(resStream,"utf-8"));
		StringBuffer resBuffer = new StringBuffer();
		String resTemp = "";
		while ((resTemp = br.readLine()) != null)
		{
			resBuffer.append(resTemp);
		}
		reValue = resBuffer.toString();
		if(reValue.startsWith("{")){
			reValue = "["+reValue+"]";
		}
		br.close();
		resStream.close();
	}
	
	if(reValue.length()>0){
		surveyList = JSONArray.fromObject(reValue);
	}
	

} catch (HttpException httpexc)
{	
	error_code= 111;
	//out.print("1:"+httpexc+"<br>");
} catch (IOException ioexc)
{	
	error_code= 112;
	//out.print("2:"+ioexc+"<br>");
} catch (Exception ex)
{
	error_code= 113;
	//out.print("3:"+ex+"<br>");
}finally {
		jsonObject.put("error_code",error_code);
		response.setContentType("application/json");
		response.getWriter().write(jsonObject.toString());
	}
//out.print(surveyURL);
//out.print("<br>why<br>");
//out.print(surveyList.toString()+"<br>");
//out.print(reValue+"here");
%>
<body>
<script type="text/javascript">
window.onload(function(){
	callSendMail();
});
function callSendMail(){
	masNo= $('#hideMasNo').val();
	qnNo = $('#hideQnNo').val();
	var masNQnNo = "o="+masNo+"&v="+qnNo;
	$.ajax({
        type: "post",
        url: "/sendQnNo.html",
        data: masNQnNo,
		dataType: "json",
        async: true,
        error: function(er) {
			//console.log("no"+qnNo);
		},
        success: function(or) {
			//console.log("yes"+qnNo);
		}
	});
}
</script>
</body>