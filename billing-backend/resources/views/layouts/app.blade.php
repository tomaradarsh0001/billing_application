<!DOCTYPE html>
<html lang="zxx">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <!-- CSS Links -->
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap1.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendors/themefy_icon/themify-icons.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendors/niceselect/css/nice-select.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendors/owl_carousel/css/owl.carousel.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendors/gijgo/gijgo.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendors/font_awesome/css/all.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendors/tagsinput/tagsinput.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendors/datepicker/date-picker.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendors/vectormap-home/vectormap-2.0.2.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendors/scroll/scrollable.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendors/datatable/css/jquery.dataTables.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendors/datatable/css/responsive.dataTables.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendors/datatable/css/buttons.dataTables.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendors/text_editor/summernote-bs4.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendors/morris/morris.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendors/material_icon/material-icons.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/metisMenu.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/style1.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/colors/default.css') }}" id="colorSkinCSS">


</head>

<body class="crm_body_bg">

    <nav class="sidebar vertical-scroll  ps-container ps-theme-default ps-active-y">
        <div class="logo d-flex justify-content-between">
            <a href="index.html"><img src="{{ asset('assets/img/logo.png')}}" alt=""></a>
            <div class="sidebar_close_icon d-lg-none">
                <i class="ti-close"></i>
            </div>
        </div>
        <ul id="sidebar_menu">
            <li class="mm-active">
                <a class="has-arrow" href="#" aria-expanded="false">
                    <div class="icon_menu">
                        <img src="{{ asset('assets/img/menu-icon/dashboard.svg')}}" alt="">
                    </div>
                    <span>Dashboard</span>
                </a>
                <ul>
                    <li><a class="active" href="index.html">Sales</a></li>
                    <li><a href="index_2.html">Default</a></li>
                    <li><a href="index_3.html">Dark Menu</a></li>
                </ul>
            </li>
            <li class="">
                <a class="has-arrow" href="#" aria-expanded="false">
                    <div class="icon_menu">
                        <img src="{{ asset('assets/img/menu-icon/2.svg')}}" alt="">
                    </div>
                    <span>Configuration</span>
                </a>
                <ul>
                    <li><a href="{{ route('configuration.create') }}">Add Configuration</a></li>
                    <li><a href="{{ route('configuration.index') }}">View Configuration</a></li>
                    <!-- <li><a href="editor.html">editor</a></li>
              <li><a href="mail_box.html">Mail Box</a></li>
              <li><a href="chat.html">Chat</a></li>
              <li><a href="faq.html">FAQ</a></li> -->
                </ul>
            </li>
            <!-- <li class="">
          <a   class="has-arrow" href="#" aria-expanded="false">
            
            <div class="icon_menu">
                <img src="{{ asset('assets/img/menu-icon/3.svg')}}" alt="">
            </div>
            <span>UI Kits</span>
          </a>
          <ul>
            <li><a href="colors.html">colors</a></li>
            <li><a href="Alerts.html">Alerts</a></li>
            <li><a href="buttons.html">Buttons</a></li>
            <li><a href="modal.html">modal</a></li>
            <li><a href="dropdown.html">Droopdowns</a></li>
            <li><a href="Badges.html">Badges</a></li>
            <li><a href="Loading_Indicators.html">Loading Indicators</a></li>
            <li><a href="State_color.html">State color</a></li>
            <li><a href="typography.html">Typography</a></li>
            <li><a href="datepicker.html">Date Picker</a></li>
          </ul>
        </li>
        <li class="">
          <a   class="has-arrow" href="#" aria-expanded="false">
            
            <div class="icon_menu">
                <img src="{{ asset('assets/img/menu-icon/4.svg')}}" alt="">
            </div>
            <span>forms</span>
          </a>
          <ul>
            <li><a href="Basic_Elements.html">Basic Elements</a></li>
            <li><a href="Groups.html">Groups</a></li>
            <li><a href="Max_Length.html">Max Length</a></li>
            <li><a href="Layouts.html">Layouts</a></li>
          </ul>
        </li>
        <li class="">
            <a href="Board.html" aria-expanded="false">
              <div class="icon_menu">
                  <img src="{{ asset('assets/img/menu-icon/5.svg')}}" alt="">
              </div>
              <span>Board</span>
            </a>
        </li>
        <li class="">
            <a  href="invoice.html" aria-expanded="false">
              <div class="icon_menu">
                  <img src="{{ asset('assets/img/menu-icon/6.svg')}}" alt="">
              </div>
              <span>Invoice</span>
            </a>
        </li>
        <li class="">
            <a  href="calender.html" aria-expanded="false">
              <div class="icon_menu">
                  <img src="{{ asset('assets/img/menu-icon/7.svg')}}" alt="">
              </div>
              <span>Calander</span>
            </a>
        </li>
        
        <li class="">
            <a   class="has-arrow" href="#" aria-expanded="false">
              
              <div class="icon_menu">
                  <img src="{{ asset('assets/img/menu-icon/8.svg')}}" alt="">
              </div>
              <span>Products</span>
            </a>
            <ul>
              <li><a href="Products.html">Products</a></li>
              <li><a href="Product_Details.html">Product Details</a></li>
              <li><a href="Cart.html">Cart</a></li>
              <li><a href="Checkout.html">Checkout</a></li>
            </ul>
          </li>
        <li class="">
          <a   class="has-arrow" href="#" aria-expanded="false">
            <div class="icon_menu">
                <img src="{{ asset('assets/img/menu-icon/8.svg')}}" alt="">
            </div>
            <span>Icons</span>
          </a>
          <ul>
            <li><a href="Fontawesome_Icon.html">Fontawesome Icon</a></li>
            <li><a href="themefy_icon.html">themefy icon</a></li>
          </ul>
        </li>

        <li class="">
            <a   class="has-arrow" href="#" aria-expanded="false">
              <div class="icon_menu">
                  <img src="{{ asset('assets/img/menu-icon/9.svg')}}" alt="">
              </div>
              <span>Animations</span>
            </a>
            <ul>
                <li><a href="wow_animation.html">Animate</a></li>
                <li><a href="Scroll_Reveal.html">Scroll Reveal</a></li>
                <li><a href="tilt.html">Tilt Animation</a></li>
                
            </ul>
          </li>
          <li class="">
            <a   class="has-arrow" href="#" aria-expanded="false">
              <div class="icon_menu">
                  <img src="{{ asset('assets/img/menu-icon/10.svg')}}" alt="">
              </div>
              <span>Components</span>
            </a>
            <ul>
              <li><a href="accordion.html">Accordions</a></li>
              <li><a href="Scrollable.html">Scrollable</a></li>
              <li><a href="notification.html">Notifications</a></li>
              <li><a href="carousel.html">Carousel</a></li>
              <li><a href="Pagination.html">Pagination</a></li>
            </ul>
          </li>

          <li class="">
            <a   class="has-arrow" href="#" aria-expanded="false">
              <div class="icon_menu">
                  <img src="{{ asset('assets/img/menu-icon/11.svg')}}" alt="">
              </div>
              <span>Table</span>
            </a>
            <ul>
                <li><a href="data_table.html">Data Tables</a></li>
                <li><a href="bootstrap_table.html">Bootstrap</a></li>
            </ul>
          </li>
          <li class="">
            <a   class="has-arrow" href="#" aria-expanded="false">
              <div class="icon_menu">
                  <img src="{{ asset('assets/img/menu-icon/12.svg')}}" alt="">
              </div>
              <span>Cards</span>
            </a>
            <ul>
                <li><a href="basic_card.html">Basic Card</a></li>
                <li><a href="theme_card.html">Theme Card</a></li>
                <li><a href="dargable_card.html">Draggable Card</a></li>
            </ul>
          </li>


        <li class="">
          <a   class="has-arrow" href="#" aria-expanded="false">
            <div class="icon_menu">
                <img src="{{ asset('assets/img/menu-icon/13.svg')}}" alt="">
            </div>
            <span>Charts</span>
          </a>
          <ul>
            <li><a href="chartjs.html">ChartJS</a></li>
            <li><a href="apex_chart.html">Apex Charts</a></li>
            <li><a href="chart_sparkline.html">Chart sparkline</a></li>
            <li><a href="am_chart.html">am-charts</a></li>
            <li><a href="nvd3_charts.html">nvd3 charts.</a></li>
          </ul>
        </li>
        

        <li class="">
          <a   class="has-arrow" href="#" aria-expanded="false">
            <div class="icon_menu">
                <img src="{{ asset('assets/img/menu-icon/14.svg')}}" alt="">
            </div>
            <span>Widgets</span>
          </a>
          <ul>
            <li><a href="chart_box_1.html">Chart Boxes 1</a></li>
            <li><a href="profilebox.html">Profile Box</a></li>
          </ul>
        </li>
        

        <li class="">
          <a   class="has-arrow" href="#" aria-expanded="false">
            <div class="icon_menu">
                <img src="{{ asset('assets/img/menu-icon/15.svg')}}" alt="">
            </div>
            <span>Maps</span>
          </a>
          <ul>
            <li><a href="mapjs.html">Maps JS</a></li>
            <li><a href="vector_map.html">Vector Maps</a></li>
          </ul>
        </li>
        <li class="">
            <a   class="has-arrow" href="#" aria-expanded="false">
              
              <div class="icon_menu">
                  <img src="{{ asset('assets/img/menu-icon/16.svg')}}" alt="">
              </div>
              <span>Pages</span>
            </a>
            <ul>
              <li><a href="login.html">Login</a></li>
              <li><a href="resister.html">Register</a></li>
              <li><a href="error_400.html">Error 404</a></li>
              <li><a href="error_500.html">Error 500</a></li>
              <li><a href="forgot_pass.html">Forgot Password</a></li>
              <li><a href="gallery.html">Gallery</a></li>
            </ul>
          </li> -->

        </ul>
    </nav>
    <!--/ sidebar  -->


    <section class="main_content dashboard_part large_header_bg">
        <!-- menu  -->
        <div class="container-fluid g-0">
            <div class="row">
                <div class="col-lg-12 p-0">
                    <div class="header_iner d-flex justify-content-between align-items-center">
                        <div class="sidebar_icon d-lg-none">
                            <i class="ti-menu"></i>
                        </div>
                        <div class="serach_field-area d-flex align-items-center">
                            <div class="search_inner">
                                <form action="#">
                                    <div class="search_field">
                                        <input type="text" placeholder="Search here...">
                                    </div>
                                    <button type="submit"> <img src="{{ asset('assets/img/icon/icon_search.svg')}}" alt=""> </button>
                                </form>
                            </div>
                            <span class="f_s_14 f_w_400 ml_25 white_text text_white">Apps</span>
                        </div>
                        <div class="header_right d-flex justify-content-between align-items-center">
                        <div class="header_notification_warp d-flex align-items-center">
    <!-- Settings Notification -->
    <li>
        <a class="set_notification_clicker nav-link-set" href="#">
            <img src="{{ asset('assets/img/icon/settings.svg') }}" alt="Settings">
        </a>
        <div class="Menu_NOtification_Wrap settings_notification_wrap">
            <div class="notification_Header">
                <h4>Settings</h4>
            </div>
            <div class="Notification_body">
    <!-- single_notify -->
    <a class="set_notification_clicker nav-link-set" href="#">
        <img src="{{ asset('assets/img/icon/rbac.png') }}" alt="Settings">
        <p>RBAC Settings</p>
    </a>
    <a class="set_notification_clicker nav-link-set" href="{{ route('configuration.index')}}">
        <img src="{{ asset('assets/img/icon/configuration.png') }}" alt="Settings">
        <p>Configuration</p>
    </a>
</div>

        </div>
    </li>

    <!-- Bell Notification -->
    <li>
        <a class="bell_notification_clicker nav-link-notify" href="#">
            <img src="{{ asset('assets/img/icon/bell.svg') }}" alt="Bell">
        </a>
        <div class="Menu_NOtification_Wrap bell_notification_wrap">
            <div class="notification_Header">
                <h4>Bell Notifications</h4>
            </div>
            <div class="Notification_body">
                <!-- single_notify -->
                <div class="single_notify d-flex align-items-center">
                    <div class="notify_thumb">
                        <a href="#"><img src="{{ asset('assets/img/staf/4.png') }}" alt="Notification"></a>
                    </div>
                    <div class="notify_content">
                        <a href="#">
                            <h5>Awesome Packages</h5>
                        </a>
                        <p>Lorem ipsum dolor sit amet</p>
                    </div>
                </div>
                <!-- Add more single_notify elements as needed -->
            </div>
            <div class="nofity_footer">
                <div class="submit_button text-center pt_20">
                    <a href="#" class="btn_1">See More</a>
                </div>
            </div>
        </div>
    </li>

    <!-- Chatbox -->
    <li>
        <a class="CHATBOX_open nav-link-notify" href="#">
            <img src="{{ asset('assets/img/icon/msg.svg') }}" alt="Chat">
        </a>
    </li>
</div>

                            <div class="profile_info">
                                <img src="{{ asset('assets/img/client_img.png')}}" alt="#">
                                <div class="profile_info_iner">
                                    <div class="profile_author_name">
                                        <p>{{ Auth::user()->email }} </p>
                                        <h5>{{ Auth::user()->name }}</h5>
                                    </div>
                                    <div class="profile_info_details">
                                        <a href="#">My Profile </a>
                                        <div class="settings_dropdown">
                                            <a href="#">Settings</a>
                                            <div class="dropdown_content">
                                                <a href="{{ route('users.index') }}">Users</a>
                                                <a href="{{ route('roles.index') }}">Roles</a>
                                                <a href="{{ route('permissions.index') }}">Permissions</a>
                                               
                                            </div>
                                        </div>
                                        <form method="POST" action="{{ route('logout') }}" style="display: inline;">
                                            @csrf
                                            <a href="" onclick="event.preventDefault(); this.closest('form').submit();">Logout</a>
                                        </form>
                                        <style>
                                            .profile_info_details {
                                                position: relative;
                                            }

                                            .settings_dropdown {
                                                position: relative;
                                                display: inline-block;
                                            }

                                            .settings_dropdown .dropdown_content {
                                                display: none;
                                                position: absolute;
                                                background-color: #f9f9f9;
                                                min-width: 160px;
                                                box-shadow: 0px 8px 16px rgba(0, 0, 0, 0.2);
                                                z-index: 1;
                                            }

                                            .settings_dropdown:hover .dropdown_content {
                                                display: block;
                                            }

                                            .dropdown_content a {
                                                color: black;
                                                padding: 8px 12px;
                                                text-decoration: none;
                                                display: block;
                                            }

                                            .dropdown_content a:hover {
                                                background-color: #ddd;
                                            }
                                        </style>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @yield('content')
            <!-- footer part -->
            <div class="footer_part">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="footer_iner text-center">
                                <p>2020 © Influence - Designed by <a href="#"> <i class="ti-heart"></i> </a><a href="#"> Dashboard</a></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
    </section>
    <!-- main content part end -->

    <!-- ### CHAT_MESSAGE_BOX   ### -->

    <div class="CHAT_MESSAGE_POPUPBOX">
        <div class="CHAT_POPUP_HEADER">
            <div class="MSEESAGE_CHATBOX_CLOSE">
                <svg width="12" height="12" viewBox="0 0 12 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M7.09939 5.98831L11.772 10.661C12.076 10.965 12.076 11.4564 11.772 11.7603C11.468 12.0643 10.9766 12.0643 10.6726 11.7603L5.99994 7.08762L1.32737 11.7603C1.02329 12.0643 0.532002 12.0643 0.228062 11.7603C-0.0760207 11.4564 -0.0760207 10.965 0.228062 10.661L4.90063 5.98831L0.228062 1.3156C-0.0760207 1.01166 -0.0760207 0.520226 0.228062 0.216286C0.379534 0.0646715 0.578697 -0.0114918 0.777717 -0.0114918C0.976738 -0.0114918 1.17576 0.0646715 1.32737 0.216286L5.99994 4.889L10.6726 0.216286C10.8243 0.0646715 11.0233 -0.0114918 11.2223 -0.0114918C11.4213 -0.0114918 11.6203 0.0646715 11.772 0.216286C12.076 0.520226 12.076 1.01166 11.772 1.3156L7.09939 5.98831Z" fill="white" />
                </svg>

            </div>
            <h3>Chat with us</h3>
            <div class="Chat_Listed_member">
                <ul>
                    <li>
                        <a href="#">
                            <div class="member_thumb">
                                <img src="{{ asset('assets/img/staf/1.png')}}" alt="">
                            </div>
                        </a>
                    </li>
                    <li>
                        <a href="#">
                            <div class="member_thumb">
                                <img src="{{ asset('assets/img/staf/2.png')}}" alt="">
                            </div>
                        </a>
                    </li>
                    <li>
                        <a href="#">
                            <div class="member_thumb">
                                <img src="{{ asset('assets/img/staf/3.png')}}" alt="">
                            </div>
                        </a>
                    </li>
                    <li>
                        <a href="#">
                            <div class="member_thumb">
                                <img src="{{ asset('assets/img/staf/4.png')}}" alt="">
                            </div>
                        </a>
                    </li>
                    <li>
                        <a href="#">
                            <div class="member_thumb">
                                <img src="{{ asset('assets/img/staf/5.png')}}" alt="">
                            </div>
                        </a>
                    </li>
                    <li>
                        <a href="#">
                            <div class="member_thumb">
                                <div class="more_member_count">
                                    <span>90+</span>
                                </div>
                            </div>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
        <div class="CHAT_POPUP_BODY">
            <p class="mesaged_send_date">
                Sunday, 12 January
            </p>

            <div class="CHATING_SENDER">
                <div class="SMS_thumb">
                    <img src="{{ asset('assets/img/staf/1.png')}}" alt="">
                </div>
                <div class="SEND_SMS_VIEW">
                    <P>Hi! Welcome .
                        How can I help you?</P>
                </div>
            </div>

            <div class="CHATING_SENDER CHATING_RECEIVEr">

                <div class="SEND_SMS_VIEW">
                    <P>Hello</P>
                </div>
                <div class="SMS_thumb">
                    <img src="{{ asset('assets/img/staf/1.png')}}" alt="">
                </div>
            </div>

        </div>
        <div class="CHAT_POPUP_BOTTOM">
            <div class="chat_input_box d-flex align-items-center">
                <div class="input-group">
                    <input type="text" class="form-control" placeholder="Write your message" aria-label="Recipient's username" aria-describedby="basic-addon2">
                    <div class="input-group-append">
                        <button class="btn " type="button">
                            <svg width="22" height="22" viewBox="0 0 22 22" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M18.7821 3.21895C14.4908 -1.07281 7.50882 -1.07281 3.2183 3.21792C-1.07304 7.50864 -1.07263 14.4908 3.21872 18.7824C7.50882 23.0729 14.4908 23.0729 18.7817 18.7815C23.0726 14.4908 23.0724 7.50906 18.7821 3.21895ZM17.5813 17.5815C13.9525 21.2103 8.04773 21.2108 4.41871 17.5819C0.78907 13.9525 0.789485 8.04714 4.41871 4.41832C8.04752 0.789719 13.9521 0.789304 17.5817 4.41874C21.2105 8.04755 21.2101 13.9529 17.5813 17.5815ZM6.89503 8.02162C6.89503 7.31138 7.47107 6.73534 8.18131 6.73534C8.89135 6.73534 9.46739 7.31117 9.46739 8.02162C9.46739 8.73228 8.89135 9.30811 8.18131 9.30811C7.47107 9.30811 6.89503 8.73228 6.89503 8.02162ZM12.7274 8.02162C12.7274 7.31138 13.3038 6.73534 14.0141 6.73534C14.7241 6.73534 15.3002 7.31117 15.3002 8.02162C15.3002 8.73228 14.7243 9.30811 14.0141 9.30811C13.3038 9.30811 12.7274 8.73228 12.7274 8.02162ZM15.7683 13.2898C14.9712 15.1332 13.1043 16.3243 11.0126 16.3243C8.8758 16.3243 6.99792 15.1272 6.22834 13.2744C6.09642 12.9573 6.24681 12.593 6.56438 12.4611C6.64238 12.4289 6.72328 12.4136 6.80293 12.4136C7.04687 12.4136 7.27836 12.5577 7.37772 12.7973C7.95376 14.1842 9.38048 15.0799 11.0126 15.0799C12.6077 15.0799 14.0261 14.1836 14.626 12.7959C14.7625 12.4804 15.1288 12.335 15.4441 12.4717C15.7594 12.6084 15.9048 12.9745 15.7683 13.2898Z" fill="#707DB7" />
                            </svg>
                        </button>
                        <button class="btn" type="button">
                            <svg width="22" height="22" viewBox="0 0 22 22" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M11 0.289062C4.92455 0.289062 0 5.08402 0 10.9996C0 16.9152 4.92455 21.7101 11 21.7101C17.0755 21.7101 22 16.9145 22 10.9996C22 5.08472 17.0755 0.289062 11 0.289062ZM11 20.3713C5.68423 20.3713 1.375 16.1755 1.375 10.9996C1.375 5.82371 5.68423 1.62788 11 1.62788C16.3158 1.62788 20.625 5.82371 20.625 10.9996C20.625 16.1755 16.3158 20.3713 11 20.3713ZM15.125 10.3302H11.6875V6.98314C11.6875 6.61363 11.3795 6.31373 11 6.31373C10.6205 6.31373 10.3125 6.61363 10.3125 6.98314V10.3302H6.875C6.4955 10.3302 6.1875 10.6301 6.1875 10.9996C6.1875 11.3691 6.4955 11.669 6.875 11.669H10.3125V15.016C10.3125 15.3855 10.6205 15.6854 11 15.6854C11.3795 15.6854 11.6875 15.3855 11.6875 15.016V11.669H15.125C15.5045 11.669 15.8125 11.3691 15.8125 10.9996C15.8125 10.6301 15.5045 10.3302 15.125 10.3302Z" fill="#707DB7" />
                            </svg>
                            <input type="file">
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div id="back-top" style="display: none;">
        <a title="Go to Top" href="#">
            <i class="ti-angle-up"></i>
        </a>
    </div>
    <!-- Scripts -->
    <script src="{{ asset('assets/js/jquery1-3.4.1.min.js') }}"></script>
    <script src="{{ asset('assets/js/popper1.min.js') }}"></script>
    <script src="{{ asset('assets/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('assets/js/metisMenu.js') }}"></script>
    <script src="{{ asset('assets/vendors/count_up/jquery.waypoints.min.js') }}"></script>
    <script src="{{ asset('assets/vendors/chartlist/Chart.min.js') }}"></script>
    <script src="{{ asset('assets/vendors/count_up/jquery.counterup.min.js') }}"></script>
    <script src="{{ asset('assets/vendors/niceselect/js/jquery.nice-select.min.js') }}"></script>
    <script src="{{ asset('assets/vendors/owl_carousel/js/owl.carousel.min.js') }}"></script>
    <script src="{{ asset('assets/vendors/datatable/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/vendors/datatable/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('assets/vendors/datatable/js/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('assets/vendors/datatable/js/buttons.flash.min.js') }}"></script>
    <script src="{{ asset('assets/vendors/datatable/js/jszip.min.js') }}"></script>
    <script src="{{ asset('assets/vendors/datatable/js/pdfmake.min.js') }}"></script>
    <script src="{{ asset('assets/vendors/datatable/js/vfs_fonts.js') }}"></script>
    <script src="{{ asset('assets/vendors/datatable/js/buttons.html5.min.js') }}"></script>
    <script src="{{ asset('assets/vendors/datatable/js/buttons.print.min.js') }}"></script>
    <script src="{{ asset('assets/vendors/datepicker/datepicker.js') }}"></script>
    <script src="{{ asset('assets/vendors/datepicker/datepicker.en.js') }}"></script>
    <script src="{{ asset('assets/vendors/datepicker/datepicker.custom.js') }}"></script>
    <script src="{{ asset('assets/js/chart.min.js') }}"></script>
    <script src="{{ asset('assets/vendors/chartjs/roundedBar.min.js') }}"></script>
    <script src="{{ asset('assets/vendors/progressbar/jquery.barfiller.js') }}"></script>
    <script src="{{ asset('assets/vendors/tagsinput/tagsinput.js') }}"></script>
    <script src="{{ asset('assets/vendors/text_editor/summernote-bs4.js') }}"></script>
    <script src="{{ asset('assets/vendors/am_chart/amcharts.js') }}"></script>
    <script src="{{ asset('assets/vendors/scroll/perfect-scrollbar.min.js') }}"></script>
    <script src="{{ asset('assets/vendors/scroll/scrollable-custom.js') }}"></script>
    <script src="{{ asset('assets/vendors/vectormap-home/vectormap-2.0.2.min.js') }}"></script>
    <script src="{{ asset('assets/vendors/vectormap-home/vectormap-world-mill-en.js') }}"></script>
    <script src="{{ asset('assets/vendors/apex_chart/apex-chart2.js') }}"></script>
    <script src="{{ asset('assets/vendors/apex_chart/apex_dashboard.js') }}"></script>
    <script src="{{ asset('assets/vendors/echart/echarts.min.js') }}"></script>
    <script src="{{ asset('assets/vendors/chart_am/core.js') }}"></script>
    <script src="{{ asset('assets/vendors/chart_am/charts.js') }}"></script>
    <script src="{{ asset('assets/vendors/chart_am/animated.js') }}"></script>
    <script src="{{ asset('assets/vendors/chart_am/kelly.js') }}"></script>
    <script src="{{ asset('assets/vendors/chart_am/chart-custom.js') }}"></script>
    <script src="{{ asset('assets/js/dashboard_init.js') }}"></script>
    <script src="{{ asset('assets/js/custom.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js"></script>
</body>

</html>