<%@page import="com.taaze.system.util.SecureTool"%>
<%@page import="org.apache.commons.logging.LogFactory"%>
<%@page import="org.apache.commons.logging.Log"%>
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
<%
	Log log = LogFactory.getLog(this.getClass());
	String cust_cuid = request.getParameter("c")!=null?request.getParameter("c").toString():"goodjob";
	String ACT_NO = request.getParameter("ACT_NO")!=null?URLEncoder.encode(request.getParameter("ACT_NO").toString(),"UTF-8"):"20191001";
	String QN_STR_TIME = request.getParameter("QN_STR_TIME")!=null?URLEncoder.encode(request.getParameter("QN_STR_TIME").toString(),"UTF-8"):"2019-10-01 00:00:00";
	String QN_END_TIME = request.getParameter("QN_END_TIME")!=null?URLEncoder.encode(request.getParameter("QN_END_TIME").toString(),"UTF-8"):"2019-10-01 11:11:11";
	String ANS_STR_TIME = request.getParameter("ANS_STR_TIME")!=null?URLEncoder.encode(request.getParameter("ANS_STR_TIME").toString(),"UTF-8"):"2019-10-01 00:00:00";
	String ANS_END_TIME = request.getParameter("ANS_END_TIME")!=null?URLEncoder.encode(request.getParameter("ANS_END_TIME").toString(),"UTF-8"):"2019-10-01 11:11:11";
	String RCV_NM = request.getParameter("RCV_NM")!=null?URLEncoder.encode(request.getParameter("RCV_NM").toString(),"UTF-8"):"ㄅㄅ";
	String RCV_MAIL = request.getParameter("RCV_MAIL")!=null?URLEncoder.encode(request.getParameter("RCV_MAIL").toString(),"UTF-8"):"hzyhzy1011@gmail.com";
	String Gift1 = request.getParameter("Gift1")!=null?URLEncoder.encode(request.getParameter("Gift1").toString(),"UTF-8"):"";
	String Gift2 = request.getParameter("Gift2")!=null?URLEncoder.encode(request.getParameter("Gift2").toString(),"UTF-8"):"";
	String AnswerQ1 = request.getParameter("AnswerQ1")!=null?URLEncoder.encode(request.getParameter("AnswerQ1").toString(),"UTF-8"):"No";
	String AnswerQ2 = request.getParameter("AnswerQ2")!=null?URLEncoder.encode(request.getParameter("AnswerQ2").toString(),"UTF-8"):"No";
	String AnswerQ3 = request.getParameter("AnswerQ3")!=null?URLEncoder.encode(request.getParameter("AnswerQ3").toString(),"UTF-8"):"No";
	String AnswerQ4 = request.getParameter("AnswerQ4")!=null?URLEncoder.encode(request.getParameter("AnswerQ4").toString(),"UTF-8"):"No";
	Customer c = LoginUtil.getLoginCustomer(request);
	Connection conn = null;
	ResultSet rs = null;
	PreparedStatement pstmt = null;
	JSONObject jsonObject = new JSONObject();
	String queryStr = "";
	String excuteStr = "";
		try {
			
			String id = c.getCustId();
			String cust_name = c.getCustNm();
			String email = c.getMailMain();
			String GIFT_SN = "1234567";
			int survey_no = 6000;
			int survey_count = 0;
			
			queryStr = " select count(*) as totalNum from QN_REC_MAIN and ACT_NO = '20191001'";
			pstmt = conn.prepareStatement(queryStr);
			rs = pstmt.executeQuery();
			if(rs.next()) {
				survey_count = rs.getInt("totalNum");
			}
			
			int ins_num = survey_count+1;		//	   1,	   2,      3,		 4,			 5,		     6,		  7,
			excuteStr = " insert into QN_REC_MAIN(ACT_NO,CUST_ID,CUST_NM,CUST_MAIL,QN_STR_TIME,QN_END_TIME,CRT_USER,CRT_TIME)values(?,?,?,?,?,?,?,sysdate) ";
			pstmt = conn.prepareStatement(excuteStr);
			pstmt.setString(1,ACT_NO);
			pstmt.setString(2,id);
			pstmt.setString(3,cust_name);
			pstmt.setString(4,email);
			pstmt.setString(5,QN_STR_TIME);
			pstmt.setString(6,QN_END_TIME);
			pstmt.setString(7,cust_name);
			pstmt.executeUpdate();
			
			int i = 1;
			
			for(i=1,i<4,i++){
												//	     1,      2,     3,      4,			 5,	          6,		   7
			excuteStr = " insert into QN_REC_DETAIL(ACT_NO,CUST_ID,QST_NO,ANS_CNT,GET_GIFT_FLG,ANS_STR_TIME,ANS_END_TIME)values(?,?,?,?,?,?,?) ";
			pstmt = conn.prepareStatement(excuteStr);
			pstmt.setString(1,ACT_NO);
			pstmt.setString(2,id);
			pstmt.setString(3,i);
			pstmt.setString(4,AnswerQ+i);
			pstmt.setString(5,GET_GIFT_FLG);
			pstmt.setString(6,ANS_STR_TIME);
			pstmt.setString(7,ANS_END_TIME);
			pstmt.executeUpdate();
			}
			
			String GIFT_NM = "";
			if(gift1!=null){
				
				GIFT_NM = "回饋金5元";
													//	   1,	   2,	  3,	   4,  5
				excuteStr = " insert into QN_REC_GIFT(ACT_NO,CUST_ID,GIFT_NO,GIFT_NM,QTY)values(?,?,?,?,?) ";
				pstmt = conn.prepareStatement(excuteStr);
				pstmt.setString(1,ACT_NO);
				pstmt.setString(2,id);
				pstmt.setString(3,1);
				pstmt.setString(4,GIFT_NM);
				pstmt.setString(5,1);
				pstmt.executeUpdate();
				
			}
			if(gift2!=null){
				
				GIFT_NM = "島內散步/城市散步100元抵用券";
													//	   1,	   2,	  3,	   4,  5
				excuteStr = " insert into QN_REC_GIFT(ACT_NO,CUST_ID,GIFT_NO,GIFT_NM,QTY)values(?,?,?,?,?)";
				pstmt = conn.prepareStatement(excuteStr);
				pstmt.setString(1,ACT_NO);
				pstmt.setString(2,id);
				pstmt.setString(3,2);
				pstmt.setString(4,GIFT_NM);
				pstmt.setString(5,1);
				pstmt.executeUpdate();
			}
			
			if(RCV_MAIL!=null){
				
				GIFT_NM = "給朋友的e-coupon";
													//	   1,	   2,	   3,  4,	   5,     6,	   7
				excuteStr = " insert into QN_REC_GIFT(ACT_NO,CUST_ID,GIFT_NM,QTY,GIFT_SN,RCV_NM,RCV_MAIL)values(?,?,?,?,?,?,?) ";
				pstmt = conn.prepareStatement(excuteStr);
				pstmt.setString(1,ACT_NO);
				pstmt.setString(2,id);
				pstmt.setString(3,GIFT_NM);
				pstmt.setString(4,1);
				pstmt.setString(5,GIFT_SN); //先塞一個固定值
				pstmt.setString(6,RCV_NM);
				pstmt.setString(7,RCV_MAIL);
				pstmt.executeUpdate();
			}
		
		}catch(Exception e) {
			
			out.print(e);
			log.error(" sql exception occur " + e.getMessage());
			jsonObject.put("error_desc","exception occur " + e.getMessage());
			
		} finally {
			if(pstmt!=null){
				pstmt.close();
			}
			if(conn!=null) {
				conn.close();
			}
		}
	response.setContentType("application/json");
	response.getWriter().write(jsonObject.toString());
%>