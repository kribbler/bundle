using System;
using System.Collections.Generic;
using System.Text;
using System.Data.SqlClient;
using System.Data;

namespace TestingProject
{
    public class SendOrder
    {
        public int SendMidasOrder(int pOrderID)
        {
            try
            {
                MidasService.MidasOrderService service = new TestingProject.MidasService.MidasOrderService();

                MidasService.OrderDetails orderDetails = GetOrderDetailsFromDatabase(pOrderID);
                
                return service.CreateMidasOrder(pOrderID, "MyUserName", "MyPwd", orderDetails);
            }
            catch (Exception ex)
            {
                throw new Exception(string.Format("An error occurred sending the Order to Midas: {0}", ex.Message));
            }

        }

        public MidasService.OrderDetails GetOrderDetailsFromDatabase(int pOrderID)
        {
            try
            {
                MidasService.OrderDetails orderDetails = new MidasService.OrderDetails();
                
                using (SqlConnection sqlCon = new SqlConnection("MyConnectionString"))
                {
                    using (SqlCommand sqlCom = new SqlCommand("up_SelectOrderHeader", sqlCon))
                    {
                        sqlCom.CommandType = CommandType.StoredProcedure;
                        sqlCom.Parameters.Add("@OrderID", SqlDbType.Int).Value = pOrderID;
                        sqlCom.Connection.Open();

                        SqlDataReader sqlDr = sqlCom.ExecuteReader();

                        try
                        {
                            if (sqlDr.HasRows)
                            {
                                sqlDr.Read();

                                //Your MIDAS CusID and SiteID
                                orderDetails.CusID = Convert.ToInt32(sqlDr["DealerID"]);
                                orderDetails.SiteID = Convert.ToInt32(sqlDr["SiteID"]);

                                //Customer Details
                                orderDetails.Title = sqlDr["Title"].ToString();
                                orderDetails.CusFName = sqlDr["CusFName"].ToString();
                                orderDetails.CusLName = sqlDr["CusLName"].ToString();

                                //Customer Billing Address
                                orderDetails.BillAddr1 = sqlDr["BillAddr1"].ToString();
                                orderDetails.BillAddr2 = sqlDr["BillAddr2"].ToString();
                                orderDetails.BillAddr3 = sqlDr["BillAddr3"].ToString();
                                orderDetails.BillAddr4 = sqlDr["BillAddr4"].ToString();
                                orderDetails.BillPCode = sqlDr["BillPCode"].ToString();
                                orderDetails.BillPhone = sqlDr["BillPhone"].ToString();
                                orderDetails.BillMobile = sqlDr["BillMobile"].ToString();
                                orderDetails.BillEmail = sqlDr["UserID"].ToString();

                                //Delivery Customer Details 
                                orderDetails.DelvTitle = sqlDr["DelvTitle"].ToString();
                                orderDetails.DelvFName = sqlDr["DelvFName"].ToString();
                                orderDetails.DelvLName = sqlDr["DelvLName"].ToString();

                                //Delivery Address
                                orderDetails.DelvAddr1 = sqlDr["DelvAddr1"].ToString();
                                orderDetails.DelvAddr2 = sqlDr["DelvAddr2"].ToString();
                                orderDetails.DelvAddr3 = sqlDr["DelvAddr3"].ToString();
                                orderDetails.DelvAddr4 = sqlDr["DelvAddr4"].ToString();
                                orderDetails.DelvPCode = sqlDr["DelvPCode"].ToString();
                                orderDetails.DelvPhone = sqlDr["DelvPhone"].ToString();

                                //Dates and times of fitting (if applicable)
                                if (sqlDr["FittingDate"] != DBNull.Value)
                                {
                                    orderDetails.RegNum = sqlDr["RegNum"].ToString();
                                    orderDetails.FittingDate = Convert.ToDateTime(sqlDr["FittingDate"]);

                                    if (Convert.ToBoolean(sqlDr["IsAm"]))
                                    {
                                        orderDetails.StartTime = "08:30";
                                        orderDetails.EndTime = "11:59";
                                    }
                                    else
                                    {
                                        orderDetails.StartTime = "12:00";
                                        orderDetails.EndTime = "17:30";
                                    }

                                    orderDetails.Comments = sqlDr["Comments"].ToString();
                                }

                                //Details from Bank
                                orderDetails.AuthCode = sqlDr["AuthCode"].ToString();
                                orderDetails.CCTransID = sqlDr["PasRef"].ToString();

                                //Can be setup to be whatever you need it to be
                                orderDetails.InvoiceNo = Convert.ToInt32(sqlDr["ServerID"]).ToString("00") + sqlDr["OrderID"].ToString();
                                
                                //Extra details that may or may not be filled out
                                orderDetails.ContactPhoneHome = "";
                                orderDetails.ContactPhoneMobile = "";
                                orderDetails.ContactPhoneWork = "";
                                orderDetails.ContactEmail = "";


                            }
                            
                        }
                        finally
                        {
                            sqlDr.Close();
                        }

                        sqlCom.CommandText = "up_SelectOrderLines";
                        sqlDr = sqlCom.ExecuteReader(CommandBehavior.CloseConnection);

                        try
                        {
                            List<MidasService.OrderLine> orderLineList = new List<MidasService.OrderLine>();
                            

                            while (sqlDr.Read())
                            {
                                MidasService.OrderLine orderLine = new MidasService.OrderLine();

                                orderLine.InvoiceNo = orderDetails.InvoiceNo;
                                orderLine.Code = sqlDr["StockCode"].ToString();
                                orderLine.Qty = Convert.ToInt32(sqlDr["Quantity"]);
                                orderLine.Price = Convert.ToDouble(sqlDr["CostWithVAT"]); //Price per item with VAT

                                orderLineList.Add(orderLine);
                            }

                            orderDetails.Lines = orderLineList.ToArray();
                        }
                        finally
                        {
                            sqlDr.Close();
                        }

                    }

                    
                }

                return orderDetails;
            }
            catch (Exception ex)
            {
                throw new Exception(string.Format("An error occurred getting the Order Details: {0}", ex.Message));
            }
        }

    }
}
