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
Connection conn = null;
ResultSet rs = null;
PreparedStatement pstmt = null;
JSONObject jsonObject = new JSONObject();
String queryStr = "";
int survey_count = 0;

		DataSource ds=(DataSource)SpringUtil.getSpringBeanById(this, "datasource");
		conn = ds.getConnection();
		conn.setAutoCommit(false);

		queryStr = "select count(*) as totalNum from QN_REC_MAIN where ACT_NO = 'QA201911001'";
		pstmt = conn.prepareStatement(queryStr);
		rs = pstmt.executeQuery();
		if(rs.next()) {
			survey_count = rs.getInt("totalNum");
		}
		rs.close();
	
		conn.commit();
		jsonObject.put("survey_count",survey_count);
		response.setContentType("application/json");
		response.getWriter().write(jsonObject.toString());
		conn.close();

//out.print(survey_count);
%>