@extends('layouts.app') 
@section('title', 'Dashboard')
@section('content')

<title>Welcome to Dashboard</title>
<div class="main_content_iner overly_inner ">
        <div class="container-fluid p-0 ">
            <!-- page title  -->
            <div class="row">
                <div class="col-12">
                    <div class="page_title_box d-flex align-items-center justify-content-between">
                        <div class="page_title_left">
                            <h3 class="f_s_30 f_w_700 text_white" >Dashboard</h3>
                            <ol class="breadcrumb page_bradcam mb-0">
                                <li class="breadcrumb-item"><a href="javascript:void(0);">Salessa </a></li>
                                <li class="breadcrumb-item"><a href="javascript:void(0);">Dashboard</a></li>
                                <li class="breadcrumb-item active">Sales</li>
                            </ol>
                        </div>
                        <a href="#" class="white_btn3">Create Report</a>
                    </div>
                </div>
            </div>
            <div class="row ">
                <div class="col-lg-8 card_height_100">
                    <div class="white_card mb_20">
                        <div class="white_card_header">
                            <div class="box_header m-0">
                                <div class="main-title">
                                    <h3 class="m-0">Revenue</h3>
                                </div>
                                <div class="float-lg-right float-none sales_renew_btns justify-content-end">
                                    <ul class="nav">
                                        <li class="nav-item">
                                            <a class="nav-link active" href="#">This Week</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="#">Last Week</a>
                                        </li>
                                        <li class="nav-item"><a class="nav-link" href="#">Last Month</a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="white_card_body" style="height: 286px;">
                            <canvas  id="bar" ></canvas>
                        </div>
                    </div>
                    <div class="white_card mb_20">
                        <div class="white_card_body renew_report_card d-flex align-items-center justify-content-between flex-wrap">
                            <div class="renew_report_left">
                                <h4 class="f_s_19 f_w_600 color_theme2 mb-0" >Download your earnings report</h4>
                                <p class="color_gray2 f_s_12 f_w_600" >There are many variations of passages.</p>
                            </div>
                            <div class="create_report_btn">
                                <a href="#" class="btn_1 mt-1 mb-1">Create Report</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 card_height_100 mb_20">
                    <div class="white_card">
                        <div class="white_card_header">
                            <div class="box_header m-0">
                                <div class="main-title">
                                    <h3 class="m-0">Total Sales Unit</h3>
                                </div>
                                <div class="header_more_tool">
                                    <div class="dropdown">
                                        <span class="dropdown-toggle" id="dropdownMenuButton" data-bs-toggle="dropdown">
                                          <i class="ti-more-alt"></i>
                                        </span>
                                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton">
                                          <a class="dropdown-item" href="#"> <i class="ti-eye"></i> Action</a>
                                          <a class="dropdown-item" href="#"> <i class="ti-trash"></i> Delete</a>
                                          <a class="dropdown-item" href="#"> <i class="fas fa-edit"></i> Edit</a>
                                          <a class="dropdown-item" href="#"> <i class="ti-printer"></i> Print</a>
                                          <a class="dropdown-item" href="#"> <i class="fa fa-download"></i> Download</a>
                                        </div>
                                      </div>
                                </div>
                            </div>
                        </div>
                        <div class="white_card_body p-0">
                            <div class="card_container">
                                <div id="platform_type_dates_donut" style="height:280px" ></div>
                            </div>
                        </div>
                    </div>
                    <div class="sales_unit_footer d-flex justify-content-between">
                        <div class="single_sales">
                            <p>This Month Revenue</p>
                            <h3>$57k</h3>
                            <p class="d-flex align-items-center" > <i class="ti-arrow-up"></i> <span>  14.5%</span> Up From Last Month </p>
                        </div>
                        <div class="single_sales disable_sales">
                            <p>This Month Revenue</p>
                            <h3>$14k</h3>
                            <p class="d-flex align-items-center" > <i class="ti-arrow-up"></i> <span>  14.5%</span> Up From Last Month </p>
                        </div>
                    </div>
                </div>
                
                <div class="col-lg-4">
                    <div class="white_card card_height_100 mb_20">
                        <div class="white_card_header">
                            <div class="box_header m-0">
                                <div class="main-title">
                                    <h3 class="m-0">Daily Sales</h3>
                                </div>
                                <div class="header_more_tool">
                                    <div class="dropdown">
                                        <span class="dropdown-toggle" id="dropdownMenuButton" data-bs-toggle="dropdown">
                                          <i class="ti-more-alt"></i>
                                        </span>
                                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton">
                                          <a class="dropdown-item" href="#"> <i class="ti-eye"></i> Action</a>
                                          <a class="dropdown-item" href="#"> <i class="ti-trash"></i> Delete</a>
                                          <a class="dropdown-item" href="#"> <i class="fas fa-edit"></i> Edit</a>
                                          <a class="dropdown-item" href="#"> <i class="ti-printer"></i> Print</a>
                                          <a class="dropdown-item" href="#"> <i class="fa fa-download"></i> Download</a>
                                        </div>
                                      </div>
                                </div>
                            </div>
                        </div>
                        <div class="white_card_body">
                            <div id="chart-currently"></div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="white_card card_height_100 mb_20">
                        <div class="white_card_header">
                            <div class="box_header m-0">
                                <div class="main-title">
                                    <h3 class="m-0">Summary</h3>
                                </div>
                                <div class="header_more_tool">
                                    <div class="dropdown">
                                        <span class="dropdown-toggle" id="dropdownMenuButton" data-bs-toggle="dropdown">
                                          <i class="ti-more-alt"></i>
                                        </span>
                                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton">
                                          <a class="dropdown-item" href="#"> <i class="ti-eye"></i> Action</a>
                                          <a class="dropdown-item" href="#"> <i class="ti-trash"></i> Delete</a>
                                          <a class="dropdown-item" href="#"> <i class="fas fa-edit"></i> Edit</a>
                                          <a class="dropdown-item" href="#"> <i class="ti-printer"></i> Print</a>
                                          <a class="dropdown-item" href="#"> <i class="fa fa-download"></i> Download</a>
                                        </div>
                                      </div>
                                </div>
                            </div>
                        </div>
                        <div class="white_card_body mt_30">
                            <div id="bar1" class="barfiller">
                                <div class="tipWrap">
                                    <span class="tip"></span>
                                </div>
                                <span class="fill" data-percentage="25"></span>
                            </div>
                            <div id="bar2" class="barfiller">
                                <div class="tipWrap">
                                    <span class="tip"></span>
                                </div>
                                <span class="fill" data-percentage="75"></span>
                            </div>
                            <div id="bar3" class="barfiller mb-0">
                                <div class="tipWrap">
                                    <span class="tip"></span>
                                </div>
                                <span class="fill" data-percentage="34"></span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="white_card card_height_100 mb_20">
                        <div class="white_card_header">
                            <div class="box_header m-0">
                                <div class="main-title">
                                    <h3 class="m-0">Total order</h3>
                                </div>
                                <div class="float-lg-right float-none sales_renew_btns justify-content-end">
                                    <ul class="nav">
                                        <li class="nav-item">
                                            <a class="nav-link active" href="#">Today</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="#">This week</a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div  class="white_card_body d-flex align-items-center" style="height:140px" >
                            <h4 class="f_w_900 f_s_60 mb-0 me-2" >356</h4>
                           <div class="w-100" style="height:100px"  >
                            <canvas width="100%" id="page_views" ></canvas>
                           </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="white_card card_height_100  mb_20">
                        <div class="white_card_header">
                            <div class="box_header m-0">
                                <div class="main-title">
                                    <h3 class="m-0">Transaction</h3>
                                </div>
                                <div class="header_more_tool">
                                    <div class="dropdown">
                                        <span class="dropdown-toggle" id="dropdownMenuButton" data-bs-toggle="dropdown">
                                          <i class="ti-more-alt"></i>
                                        </span>
                                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton">
                                          <a class="dropdown-item" href="#"> <i class="ti-eye"></i> Action</a>
                                          <a class="dropdown-item" href="#"> <i class="ti-trash"></i> Delete</a>
                                          <a class="dropdown-item" href="#"> <i class="fas fa-edit"></i> Edit</a>
                                          <a class="dropdown-item" href="#"> <i class="ti-printer"></i> Print</a>
                                          <a class="dropdown-item" href="#"> <i class="fa fa-download"></i> Download</a>
                                        </div>
                                      </div>
                                </div>
                            </div>
                        </div>
                        <div class="white_card_body">
                            <div class="table-responsive">
                                <table class="table bayer_table m-0">
                                    <tbody>
                                      <tr>
                                        <td >
                                            <img class="byder_thumb wh_56" src="img/Payment/1.png" alt="">
                                        </td>
                                        <td>
                                            <div class="payment_gatway">
                                                <h5 class="byer_name  f_s_16 f_w_700 color_theme">Electricity Bill</h5>
                                                <p class="color_gray f_s_12 f_w_700 ">10 Aug 03:00PM</p>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="payment_gatway text-end">
                                                <h5 class="byer_name  f_s_16 f_w_700 text_color_4">- $ 1254.00</h5>
                                            </div>
                                        </td>
                                      </tr>
                                      <tr>
                                        <td >
                                            <img class="byder_thumb wh_56" src="img/Payment/1.png" alt="">
                                        </td>
                                        <td>
                                            <div class="payment_gatway">
                                                <h5 class="byer_name  f_s_16 f_w_700 color_theme">Showroom Rent</h5>
                                                <p class="color_gray f_s_12 f_w_700 ">10 Aug 03:00PM</p>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="payment_gatway text-end">
                                                <h5 class="byer_name  f_s_16 f_w_700 text_color_5">+ $ 1254.00</h5>
                                            </div>
                                        </td>
                                      </tr>
                                      <tr>
                                        <td >
                                            <img class="byder_thumb wh_56" src="img/Payment/1.png" alt="">
                                        </td>
                                        <td>
                                            <div class="payment_gatway">
                                                <h5 class="byer_name  f_s_16 f_w_700 color_theme">Iron Costing</h5>
                                                <p class="color_gray f_s_12 f_w_700 ">10 Aug 03:00PM</p>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="payment_gatway text-end">
                                                <h5 class="byer_name  f_s_16 f_w_700 text_color_5">+ $ 1254.00</h5>
                                            </div>
                                        </td>
                                      </tr>
                                      <tr>
                                        <td >
                                            <img class="byder_thumb wh_56" src="img/Payment/1.png" alt="">
                                        </td>
                                        <td>
                                            <div class="payment_gatway">
                                                <h5 class="byer_name  f_s_16 f_w_700 color_theme">Packeging Cost</h5>
                                                <p class="color_gray f_s_12 f_w_700 ">10 Aug 03:00PM</p>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="payment_gatway text-end">
                                                <h5 class="byer_name  f_s_16 f_w_700 text_color_5">+ $ 1254.00</h5>
                                            </div>
                                        </td>
                                      </tr>
                                    </tbody>
                                  </table>
                              </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="white_card card_height_100  mb_20">
                        <div class="white_card_header">
                            <div class="box_header m-0">
                                <div class="main-title">
                                    <h3 class="m-0">News & Update</h3>
                                </div>
                                <div class="single_wrap_input">
                                    <select class="nice_Select2 wide" name="" id="">
                                        <option value="1">Today</option>
                                        <option value="1">Tomorrow</option>
                                        <option value="1">Yesterday</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="white_card_body">
                            <div class="single_update_news">
                                <h5 class="byer_name  f_s_16 f_w_600 color_theme2">36% off For pixel lights Couslations Types.</h5>
                                <p class="color_gray f_s_12 f_w_700 ">Sorem Kpsum is simply of the printing..</p>
                            </div>
                            <div class="single_update_news">
                                <h5 class="byer_name  f_s_16 f_w_600 color_theme2">We are produce new product this</h5>
                                <p class="color_gray f_s_12 f_w_700 ">Gorem Rpsum is simply text of the printing...</p>
                            </div>
                            <div class="single_update_news">
                                <h5 class="byer_name  f_s_16 f_w_600 color_theme2">50% off For COVID Couslations Types.</h5>
                                <p class="color_gray f_s_12 f_w_700 ">EoremHpsum is simply dummy...</p>
                            </div>
                            <div class="load_more_button text-center mt_30">
                                <a class="theme_text_btn d-flex align-items-center justify-content-center"  href="#">Load more <i class="ti-angle-down f_s_12 ms-2"></i> </a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="white_card card_height_100  mb_20">
                        <div class="white_card_header">
                            <div class="box_header m-0">
                                <div class="main-title">
                                    <h3 class="m-0">Account Info</h3>
                                </div>
                                <div class="header_more_tool">
                                    <div class="dropdown">
                                        <span class="dropdown-toggle" id="dropdownMenuButton" data-bs-toggle="dropdown">
                                          <i class="ti-more-alt"></i>
                                        </span>
                                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton">
                                          <a class="dropdown-item" href="#"> <i class="ti-eye"></i> Action</a>
                                          <a class="dropdown-item" href="#"> <i class="ti-trash"></i> Delete</a>
                                          <a class="dropdown-item" href="#"> <i class="fas fa-edit"></i> Edit</a>
                                          <a class="dropdown-item" href="#"> <i class="ti-printer"></i> Print</a>
                                          <a class="dropdown-item" href="#"> <i class="fa fa-download"></i> Download</a>
                                        </div>
                                      </div>
                                </div>
                            </div>
                        </div>
                        <div class="white_card_body">
                            <div class="monthly_plan_wraper">
                                <div class="single_plan d-flex align-items-center justify-content-between">
                                    <h5 class="color_theme2 f_s_14 f_w_700 mb-0" >Monthly Plan</h5>
                                    <span class="color_gray2 f_s_16 f_w_700" >$25</span>
                                </div>
                                <div class="single_plan d-flex align-items-center justify-content-between">
                                    <h5 class="color_theme2 f_s_14 f_w_700 mb-0" >Taxes</h5>
                                    <span class="color_gray2 f_s_16 f_w_700" >$14</span>
                                </div>
                                <div class="single_plan d-flex align-items-start justify-content-between">
                                    <div>
                                        <h5 class="color_theme2 f_s_14 f_w_700 mb-0" >Extera</h5>
                                        <p class="f_s_13 f_w_700" >Netflix and other bills in this
                                            month.</p>
                                    </div>
                                    <span class="color_gray2 f_s_16 f_w_700" >$25</span>
                                </div>
                                <div class="total_blance mt_20 mb_10">
                                    <span class="f_s_13 f_w_700 color_gray ">Total balance</span>
                                    <div class="total_blance_inner d-flex align-items-center flex-wrap justify-content-between">
                                        <div>
                                            <span class="f_s_40 f_w_700 color_text_3 d-block">$3650</span>
                                            <a class="badge_btn_5" href="#">+1235</a>
                                        </div>
                                        <div>
                                            <div><a class="badge_btn_6 mb_15" href="#">Today</a></div>
                                            <div><a class="badge_btn_7" href="#">This week</a></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="white_card card_height_100 mb_20">
                        <div class="date_picker_wrapper">
                            <div class="default-datepicker">
                                <div class="datepicker-here" data-language='en'></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-8">
                    <div class="white_card card_height_100  mb_20">
                        <div class="white_card_header">
                            <div class="box_header m-0">
                                <div class="main-title">
                                    <h3 class="m-0">Top Global Sales</h3>
                                </div>
                            </div>
                        </div>
                        <div class="white_card_body pb-0">
                            <div id="world-map-markers" class="dashboard_w_map" ></div>
                            <div class="row justify-content-center mt_30">
                                <div class="col-lg-9">
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <div class="single_progressbar">
                                                <h6 class="f_s_14 f_w_400" >USA</h6>
                                                <div id="bar4" class="barfiller">
                                                    <div class="tipWrap">
                                                        <span class="tip"></span>
                                                    </div>
                                                    <span class="fill" data-percentage="81"></span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="single_progressbar">
                                                <h6>Australia</h6>
                                                <div id="bar5" class="barfiller">
                                                    <div class="tipWrap">
                                                        <span class="tip"></span>
                                                    </div>
                                                    <span class="fill" data-percentage="58"></span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="single_progressbar">
                                                <h6>Brazil</h6>
                                                <div id="bar6" class="barfiller">
                                                    <div class="tipWrap">
                                                        <span class="tip"></span>
                                                    </div>
                                                    <span class="fill" data-percentage="42"></span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="single_progressbar">
                                                <h6>Latvia</h6>
                                                <div id="bar7" class="barfiller">
                                                    <div class="tipWrap">
                                                        <span class="tip"></span>
                                                    </div>
                                                    <span class="fill" data-percentage="55"></span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="white_card card_height_100 mb_30 ">
                        <div class="white_card_header">
                            <div class="box_header m-0">
                                <div class="main-title">
                                    <h3 class="m-0">Monthly Invoices</h3>
                                </div>
                                <div class="header_more_tool">
                                    <div class="dropdown">
                                        <span class="dropdown-toggle" id="dropdownMenuButton" data-bs-toggle="dropdown">
                                          <i class="ti-more-alt"></i>
                                        </span>
                                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton">
                                          <a class="dropdown-item" href="#"> <i class="ti-eye"></i> Action</a>
                                          <a class="dropdown-item" href="#"> <i class="ti-trash"></i> Delete</a>
                                          <a class="dropdown-item" href="#"> <i class="fas fa-edit"></i> Edit</a>
                                          <a class="dropdown-item" href="#"> <i class="ti-printer"></i> Print</a>
                                          <a class="dropdown-item" href="#"> <i class="fa fa-download"></i> Download</a>
                                        </div>
                                      </div>
                                </div>
                            </div>
                        </div>
                        <div class="white_card_body QA_section">
                            <div class="QA_table ">
                                <!-- table-responsive -->
                                <table class="table lms_table_active2 p-0">
                                    <thead>
                                        <tr>
                                            <th scope="col">Customer</th>
                                            <th scope="col">Product</th>
                                            <th scope="col">Invoice</th>
                                            <th scope="col">Price</th>
                                            <th scope="col">Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>
                                                <div class="customer d-flex align-items-center">
                                                    <div class="thumb_34 mr_15 mt-0"><img class="img-fluid radius_50" src="img/customers/1.png" alt=""></div>
                                                    <span class="f_s_14 f_w_400 color_text_1" >Customer</span>
                                                </div>
                                                
                                            </td>
                                            <td class="f_s_14 f_w_400 color_text_2">Sunglass</td>
                                            <td class="f_s_14 f_w_400 color_text_3">#DE2548</td>
                                            <td class="f_s_14 f_w_400 color_text_4">$350</td>
                                            <td class="f_s_14 f_w_400 text-end"><a href="#" class="badge_btn_1">Pending</a></td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <div class="customer d-flex align-items-center">
                                                    <div class="thumb_34 mr_15 mt-0"><img class="img-fluid radius_50" src="img/customers/2.png" alt=""></div>
                                                    <span class="f_s_14 f_w_400 color_text_1" >Customer</span>
                                                </div>
                                                
                                            </td>
                                            <td class="f_s_14 f_w_400 color_text_2">Sunglass</td>
                                            <td class="f_s_14 f_w_400 color_text_3">#DE2548</td>
                                            <td class="f_s_14 f_w_400 color_text_4">$350</td>
                                            <td class="f_s_14 f_w_400 text-end"><a href="#" class="badge_btn_2">Paid</a></td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <div class="customer d-flex align-items-center">
                                                    <div class="thumb_34 mr_15 mt-0"><img class="img-fluid radius_50" src="img/customers/3.png" alt=""></div>
                                                    <span class="f_s_14 f_w_400 color_text_1" >Customer</span>
                                                </div>
                                                
                                            </td>
                                            <td class="f_s_14 f_w_400 color_text_2">Sunglass</td>
                                            <td class="f_s_14 f_w_400 color_text_3">#DE2548</td>
                                            <td class="f_s_14 f_w_400 color_text_4">$350</td>
                                            <td class="f_s_14 f_w_400 text-end"><a href="#" class="badge_btn_3">Shipped</a></td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <div class="customer d-flex align-items-center">
                                                    <div class="thumb_34 mr_15 mt-0"><img class="img-fluid radius_50" src="img/customers/4.png" alt=""></div>
                                                    <span class="f_s_14 f_w_400 color_text_1" >Customer</span>
                                                </div>
                                                
                                            </td>
                                            <td class="f_s_14 f_w_400 color_text_2">Sunglass</td>
                                            <td class="f_s_14 f_w_400 color_text_3">#DE2548</td>
                                            <td class="f_s_14 f_w_400 color_text_4">$350</td>
                                            <td class="f_s_14 f_w_400 text-end"><a href="#" class="badge_btn_3">Shipped</a></td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <div class="customer d-flex align-items-center">
                                                    <div class="thumb_34 mr_15 mt-0"><img class="img-fluid radius_50" src="img/customers/5.png" alt=""></div>
                                                    <span class="f_s_14 f_w_400 color_text_1" >Customer</span>
                                                </div>
                                                
                                            </td>
                                            <td class="f_s_14 f_w_400 color_text_2">Sunglass</td>
                                            <td class="f_s_14 f_w_400 color_text_3">#DE2548</td>
                                            <td class="f_s_14 f_w_400 color_text_4">$350</td>
                                            <td class="f_s_14 f_w_400 text-end"><a href="#" class="badge_btn_2">Paid</a></td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <div class="customer d-flex align-items-center">
                                                    <div class="thumb_34 mr_15 mt-0"><img class="img-fluid radius_50" src="img/customers/6.png" alt=""></div>
                                                    <span class="f_s_14 f_w_400 color_text_1" >Customer</span>
                                                </div>
                                                
                                            </td>
                                            <td class="f_s_14 f_w_400 color_text_2">Sunglass</td>
                                            <td class="f_s_14 f_w_400 color_text_3">#DE2548</td>
                                            <td class="f_s_14 f_w_400 color_text_4">$350</td>
                                            <td class="f_s_14 f_w_400 text-end"><a href="#" class="badge_btn_4 ">Delivered</a></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="white_card card_height_100 mb_20 ">
                        <div class="white_card_header">
                            <div class="box_header m-0">
                                <div class="main-title">
                                    <h3 class="m-0">Top Selling Product</h3>
                                </div>
                                <div class="header_more_tool">
                                    <div class="dropdown">
                                        <span class="dropdown-toggle" id="dropdownMenuButton" data-bs-toggle="dropdown">
                                          <i class="ti-more-alt"></i>
                                        </span>
                                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton">
                                          <a class="dropdown-item" href="#"> <i class="ti-eye"></i> Action</a>
                                          <a class="dropdown-item" href="#"> <i class="ti-trash"></i> Delete</a>
                                          <a class="dropdown-item" href="#"> <i class="fas fa-edit"></i> Edit</a>
                                          <a class="dropdown-item" href="#"> <i class="ti-printer"></i> Print</a>
                                          <a class="dropdown-item" href="#"> <i class="fa fa-download"></i> Download</a>
                                        </div>
                                      </div>
                                </div>
                            </div>
                        </div>
                        <div class="white_card_body QA_section">
                            <div class="QA_table ">
                                <!-- table-responsive -->
                                <table class="table lms_table_active2 p-0">
                                    <thead>
                                        <tr>
                                            <th scope="col">Product 1</th>
                                            <th scope="col">Price</th>
                                            <th scope="col">Discount</th>
                                            <th scope="col">Sold</th>
                                            <th scope="col">Source</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>
                                                <div class="customer d-flex align-items-center">
                                                    <div class="thumb_34 mr_15 mt-0"><img class="img-fluid radius_50" src="img/customers/pro_1.png" alt=""></div>
                                                    <span class="f_s_14 f_w_400 color_text_1" >Product 1</span>
                                                </div>
                                                
                                            </td>
                                            <td class="f_s_14 f_w_400 color_text_2">$564</td>
                                            <td class="f_s_14 f_w_400 color_text_3">#DE2548</td>
                                            <td class="f_s_14 f_w_400 color_text_4">60</td>
                                            <td class="f_s_14 f_w_400 text-end"><a href="#" class="text_color_1">Google</a></td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <div class="customer d-flex align-items-center">
                                                    <div class="thumb_34 mr_15 mt-0"><img class="img-fluid radius_50" src="img/customers/pro_2.png" alt=""></div>
                                                    <span class="f_s_14 f_w_400 color_text_1" >Product 1</span>
                                                </div>
                                                
                                            </td>
                                            <td class="f_s_14 f_w_400 color_text_2">$564</td>
                                            <td class="f_s_14 f_w_400 color_text_3">#DE2548</td>
                                            <td class="f_s_14 f_w_400 color_text_4">60</td>
                                            <td class="f_s_14 f_w_400 text-end"><a href="#" class="text_color_2">Direct</a></td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <div class="customer d-flex align-items-center">
                                                    <div class="thumb_34 mr_15 mt-0"><img class="img-fluid radius_50" src="img/customers/pro_3.png" alt=""></div>
                                                    <span class="f_s_14 f_w_400 color_text_1" >Product 1</span>
                                                </div>
                                                
                                            </td>
                                            <td class="f_s_14 f_w_400 color_text_2">$564</td>
                                            <td class="f_s_14 f_w_400 color_text_3">#DE2548</td>
                                            <td class="f_s_14 f_w_400 color_text_4">60</td>
                                            <td class="f_s_14 f_w_400 text-end"><a href="#" class="text_color_1">Email</a></td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <div class="customer d-flex align-items-center">
                                                    <div class="thumb_34 mr_15 mt-0"><img class="img-fluid radius_50" src="img/customers/pro_4.png" alt=""></div>
                                                    <span class="f_s_14 f_w_400 color_text_1" >Product 1</span>
                                                </div>
                                                
                                            </td>
                                            <td class="f_s_14 f_w_400 color_text_2">$564</td>
                                            <td class="f_s_14 f_w_400 color_text_3">#DE2548</td>
                                            <td class="f_s_14 f_w_400 color_text_4">60</td>
                                            <td class="f_s_14 f_w_400 text-end"><a href="#" class="text_color_3">Refferal</a></td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <div class="customer d-flex align-items-center">
                                                    <div class="thumb_34 mr_15 mt-0"><img class="img-fluid radius_50" src="img/customers/pro_5.png" alt=""></div>
                                                    <span class="f_s_14 f_w_400 color_text_1" >Product 1</span>
                                                </div>
                                                
                                            </td>
                                            <td class="f_s_14 f_w_400 color_text_2">$564</td>
                                            <td class="f_s_14 f_w_400 color_text_3">#DE2548</td>
                                            <td class="f_s_14 f_w_400 color_text_4">60</td>
                                            <td class="f_s_14 f_w_400 text-end"><a href="#" class="text_color_2">Direct</a></td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <div class="customer d-flex align-items-center">
                                                    <div class="thumb_34 mr_15 mt-0"><img class="img-fluid radius_50" src="img/customers/pro_6.png" alt=""></div>
                                                    <span class="f_s_14 f_w_400 color_text_1" >Product 1</span>
                                                </div>
                                                
                                            </td>
                                            <td class="f_s_14 f_w_400 color_text_2">$564</td>
                                            <td class="f_s_14 f_w_400 color_text_3">#DE2548</td>
                                            <td class="f_s_14 f_w_400 color_text_4">60</td>
                                            <td class="f_s_14 f_w_400 text-end"><a href="#" class="text_color_3">Refferal</a></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-8">
                    <div class="white_card card_height_100 mb_20 ">
                        <div class="white_card_header">
                            <div class="box_header m-0">
                                <div class="main-title">
                                    <h3 class="m-0">Popular Products</h3>
                                </div>
                                <div class="header_more_tool">
                                    <div class="dropdown">
                                        <span class="dropdown-toggle" id="dropdownMenuButton" data-bs-toggle="dropdown">
                                          <i class="ti-more-alt"></i>
                                        </span>
                                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton">
                                          <a class="dropdown-item" href="#"> <i class="ti-eye"></i> Action</a>
                                          <a class="dropdown-item" href="#"> <i class="ti-trash"></i> Delete</a>
                                          <a class="dropdown-item" href="#"> <i class="fas fa-edit"></i> Edit</a>
                                          <a class="dropdown-item" href="#"> <i class="ti-printer"></i> Print</a>
                                          <a class="dropdown-item" href="#"> <i class="fa fa-download"></i> Download</a>
                                        </div>
                                      </div>
                                </div>
                            </div>
                        </div>
                        <div class="white_card_body QA_section">
                            <div class="QA_table ">
                                <!-- table-responsive -->
                                <table class="table lms_table_active2 p-0">
                                    <thead>
                                        <tr>
                                            <th scope="col">Product</th>
                                            <th scope="col">Product Code</th>
                                            <th scope="col">Price</th>
                                            <th scope="col">Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>
                                                <div class="customer d-flex align-items-center">
                                                    <div class="thumb_62 mr_15 mt-0"><img class="img-fluid radius_50" src="img/customers/pro_big.png" alt=""></div>
                                                    <span class="f_s_20 f_w_400 color_text_3" >Unique Watch</span>
                                                </div>
                                                
                                            </td>
                                            <td class="f_s_14 f_w_400 color_text_4">#DE2548</td>
                                            <td class="f_s_14 f_w_400 color_text_3">$99.00</td>
                                            <td class="f_s_14 f_w_400 text-end"><a href="#" class="badge_btn_1">354 sold</a></td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <div class="customer d-flex align-items-center">
                                                    <div class="thumb_62 mr_15 mt-0"><img class="img-fluid radius_50" src="img/customers/pro_big_1.png" alt=""></div>
                                                    <span class="f_s_20 f_w_400 color_text_3" >Wireless Headphone</span>
                                                </div>
                                                
                                            </td>
                                            <td class="f_s_14 f_w_400 color_text_4">#DE2548</td>
                                            <td class="f_s_14 f_w_400 color_text_3">$99.00</td>
                                            <td class="f_s_14 f_w_400 text-end"><a href="#" class="badge_btn_1">354 sold</a></td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <div class="customer d-flex align-items-center">
                                                    <div class="thumb_62 mr_15 mt-0"><img class="img-fluid radius_50" src="img/customers/pro_big_2.png" alt=""></div>
                                                    <span class="f_s_20 f_w_400 color_text_3" >Sport Shoe</span>
                                                </div>
                                                
                                            </td>
                                            <td class="f_s_14 f_w_400 color_text_4">#DE2548</td>
                                            <td class="f_s_14 f_w_400 color_text_3">$99.00</td>
                                            <td class="f_s_14 f_w_400 text-end"><a href="#" class="badge_btn_1">354 sold</a></td>
                                        </tr>
                                    </tbody>
                                </table>
                                <a href="#" class="badge_btn_semi mt_30 ml_15">View All</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="white_card card_height_100 mb_20 ">
                        <div class="white_card_header">
                            <div class="box_header m-0">
                                <div class="main-title">
                                    <h3 class="m-0">Market valus</h3>
                                </div>
                                <div class="single_wrap_input">
                                    <select class="nice_Select2 wide" name="" id="">
                                        <option value="1">year</option>
                                        <option value="1">month</option>
                                        <option value="1">day</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="white_card_body QA_section">
                            <div class="radar-chart">
                                <div id="marketchart"></div>
                              </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


@endsection