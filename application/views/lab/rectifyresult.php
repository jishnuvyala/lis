<!DOCTYPE html>
<style type="text/css">
    .table-border {
    }
</style>
<head>
<?php $this->load->view('includes/css');?>
    <style type="text/css">
        table td{

            width: auto;
        }
    </style>
    <style type="text/css">
        .highlightred { background-color: indianred; }
        .highlightgreen { background-color: greenyellow; }

        </style>
</head>
<body>

<div>
    <div class="navbar navbar-inverse set-radius-zero" >
        <div class="container">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="../index.html">

                    <img src="assets/img/logo1.png" />
                </a>

            </div>

            <div class="right-div">
                <a href="#" class="btn btn-info pull-right">LOG ME OUT</a>
            </div>
        </div>
    </div>
    <!-- LOGO HEADER END-->
    <?php $this->load->view('includes/menu');?>
     <!-- MENU SECTION END-->
    <div class="content-wrapper">
        <div class="container-fluid">
             <div class="row pad-botm">
                 <div class="col-md-12 col-sm-12 col-xs-12">
                     <h4 class="header-line">Collect/Recieve Samples</h4>

                 </div>

             </div>

                <div class="col-md-12">

                    <div class="panel panel-default">
                        <div class="panel-heading">

                        </div>
                        <div class="panel-body panel-default">
                            <form id="search">
                            <div class="form-group">
                                <div class="col-md-1">
                                    <input id="labno" name="labno" type="text" placeholder="LabNo" class="form-control input-sm" >
                                </div>
                                <label class="col-md-1 control-label">From date</label>
                                <div class="col-md-2">
                                    <input id="frmdate" name="frmdate" type="date" placeholder="From Date"  class="form-control input-sm" >
                                </div>
                                <label class="col-md-1 control-label">To date</label>
                                <div class="col-md-2">
                                    <input id="todate" name="todate" type="date" placeholder="To dateDate" class="form-control input-sm" >
                                </div>
                                <label class="col-md-1 control-label">Status</label>
                                <div class="col-md-2">
                                    <select id="status" name="status" class="input-sm" >

                                        <option value="4">Cerified</option>
                                        <option value="5">Rectified</option>
                                        </select>
                                </div>

                                <div class="col-md-2">
                                    <button id="find" name="search" class="btn btn-success" type="submit">Find</button>
                                </div>
                            </div>
                        </div>
                        </form>

            </div>
            <div class="row">
                <div class="col-md-12 col-lg-12">
                    <div id="alert"></div>

                    <!-- Advanced Tables -->
                    <div class="panel panel-info">
                        <div class="panel-heading">

                        </div>
                        <div class="panel-body " style=" overflow-y: scroll;">
                            <div class="table table-responsive ">
                                <table  class="table table-bordered " id="resulttable">
                                    <thead>
                                    <tr>

                                        <th>Patient_Name</th>
                                        <th>Lab_No </th>
                                        <th>Service</th>
                                        <th>Lab_Service</th>
                                        <th class="hidden">Order_ID</th>
                                        <th class="col-md-4">&nbsp;&nbsp;&nbsp;&nbsp;Sample_ID&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>
                                        <th>Status</th>
                                        <th>Sample</th>
                                        <th>Container</th>
                                        <th>To_Range</th>
                                        <th>From_Range</th>
                                        <th>Unit</th>
                                        <th>Result</th>
                                        <th>Process&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>
                                        <th>Ordered_date</th>
                                        <th>Ordered_By</th>
                                        <th>Collected_date</th>
                                        <th>Collected_by</th>

                                    </tr>


                                    </thead>
                                    <tbody>



                                    </tbody>
                                </table>
                            </div>

                        </div>
                    </div>

    </div>
</div>
        </div>
        </div>
     <!-- CONTENT-WRAPPER SECTION END-->
<section class="footer-section">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                &copy; 2015 vyalatech.com |<a href="http://www.vyalatech.com/" target="_blank"  > Devolped by : Vyala Healthcare Divison</a>
            </div>

        </div>
    </div>
</section>
      <!-- FOOTER SECTION END-->
    <!-- JAVASCRIPT FILES PLACED AT THE BOTTOM TO REDUCE THE LOADING TIME  -->
    <!-- CORE JQUERY  -->
    <?php $this->load->view('includes/js');?>
</body>
<script>
  $(document).ready(function(){

       $("#search").submit(function(e)
       {
           e.preventDefault();
           $("#resulttable td").remove();
           var datastring=$("#search").serialize();
           alert(datastring);

           $.ajax({
               type:"POST",
               url:"<?php echo base_url().'result_processing/search'?>",
               data:datastring,
               datatype:"html",
               success:function(response)
               {
                   $("#resulttable").append(response);

               }

           });

       });

      $(document).on('click', '#numsave' , function() {
          //code here ....
          var orderid = $(this).closest("tr").find('td:eq(4)').text();
          var result=$(this).closest("tr").find('#numresult').val();
          var savebutton= $(this).closest("tr").find('#numsave');
          if(result==''){
              Lobibox.notify("warning",
                  {
                      msg: "Result can't be empty"
                  });
          }
          else
          {
              $.ajax({
                  type:"post",
                  url:"<?php echo base_url().'result_processing/save_numeric_result'?>",
                  data :{
                      orderid:orderid,
                      result:result
                  },
                  datatype:"json",
                  success :function(response)
                  {
                      var response=JSON.parse(response);
                      if(response.status===true)
                      {
                          Lobibox.notify("success",
                              {
                                  msg: "Result is saved"
                              });
                          savebutton.hide();


                      }
                      else
                      {
                          alert("failed");
                      }
                  },
                  error: function (jqXHR, textStatus, errorThrown) {

                      Lobibox.alert("error",
                          {   width : 300,
                              msg: errorThrown
                          });

                  }



              });
          }


      });
      $(document).on('click', '#numcertify' , function() {
          //code here ....
          var orderid = $(this).closest("tr").find('td:eq(4)').text();
          var result=$(this).closest("tr").find('#numresult').val();
          var savebutton= $(this).closest("tr").find('#numsave');
          var certifybutton= $(this).closest("tr").find('#numcertify');
          var resultfield=$(this).closest("tr").find('#numresult');
          if(result==''){
              Lobibox.notify("warning",
                  {
                      msg: "Result can't be empty"
                  });
          }
          else
          {
              $.ajax({
                  type:"post",
                  url:"<?php echo base_url().'result_processing/certify_numeric_result'?>",
                  data :{
                      orderid:orderid,
                      result:result
                  },
                  datatype:"json",
                  success :function(response)
                  {
                      var response=JSON.parse(response);
                      if(response.status===true)
                      {
                          Lobibox.notify("success",
                              {
                                  msg: "Result is certified"
                              });
                          savebutton.hide();
                          certifybutton.hide();
                          resultfield.prop("disabled", true);


                      }
                      else
                      {
                          Lobibox.notify("error",
                              {
                                  msg: "Something Went wrong"
                              });

                      }
                  },
                  error: function (jqXHR, textStatus, errorThrown) {

                      Lobibox.alert("error",
                          {   width : 300,
                              msg: errorThrown
                          });

                  }



              });
          }


      });
      $(document).on('click', '#numrectify' , function() {
          //code here ....
          var orderid = $(this).closest("tr").find('td:eq(4)').text();
          var result=$(this).closest("tr").find('#numresult').val();
          var savebutton= $(this).closest("tr").find('#numsave');
          var certifybutton= $(this).closest("tr").find('#numrectify');
          var resultfield=$(this).closest("tr").find('#numresult');
          if(result==''){
              Lobibox.notify("warning",
                  {
                      msg: "Result can't be empty"
                  });
          }
          else
          {
              $.ajax({
                  type:"post",
                  url:"<?php echo base_url().'result_processing/rectify_numeric_result'?>",
                  data :{
                      orderid:orderid,
                      result:result
                  },
                  datatype:"json",
                  success :function(response)
                  {
                      var response=JSON.parse(response);
                      if(response.status===true)
                      {
                          Lobibox.notify("success",
                              {
                                  msg: "Result is rectified"
                              });

                          resultfield.prop("disabled", true);


                      }
                      else
                      {
                          Lobibox.notify("error",
                              {
                                  msg: "Something Went wrong"
                              });

                      }
                  },
                  error: function (jqXHR, textStatus, errorThrown) {

                      Lobibox.alert("error",
                          {   width : 300,
                              msg: errorThrown
                          });

                  }



              });
          }


      });
      $(document).on('click', '#alphasave' , function() {
          //code here ....
          var orderid = $(this).closest("tr").find('td:eq(4)').text();
          var result=$(this).closest("tr").find('#alpharesult').val();
          var savebutton= $(this).closest("tr").find('#alphasave');
          if(result=='default'){
              Lobibox.notify("warning",
                  {
                      msg: "Choose a Proper Result"
                  });
          }
          else
          {
              $.ajax({
                  type:"post",
                  url:"<?php echo base_url().'result_processing/save_alpha_result'?>",
                  data :{
                      orderid:orderid,
                      result:result
                  },
                  datatype:"json",
                  success :function(response)
                  {
                      var response=JSON.parse(response);
                      if(response.status===true)
                      {
                          Lobibox.notify("success",
                              {
                                  msg: "Result is saved"
                              });
                          savebutton.hide();


                      }
                      else
                      {
                          alert("failed");
                      }
                  },
                  error: function (jqXHR, textStatus, errorThrown) {

                      Lobibox.alert("error",
                          {   width : 300,
                              msg: errorThrown
                          });

                  }



              });
          }


      });
      $(document).on('click', '#alphacertify' , function() {
          //code here ....
          var orderid = $(this).closest("tr").find('td:eq(4)').text();
          var result=$(this).closest("tr").find('#alpharesult').val();
          var savebutton= $(this).closest("tr").find('#alphasave');
          var certifybutton= $(this).closest("tr").find('#alphacertify');
          var resultfield=$(this).closest("tr").find('#alpharesult');
          if(result=='default'){
              Lobibox.notify("warning",
                  {
                      msg: "Choose a valid result"
                  });
          }
          else
          {
              $.ajax({
                  type:"post",
                  url:"<?php echo base_url().'result_processing/certify_alpha_result'?>",
                  data :{
                      orderid:orderid,
                      result:result
                  },
                  datatype:"json",
                  success :function(response)
                  {
                      var response=JSON.parse(response);
                      if(response.status===true)
                      {
                          Lobibox.notify("success",
                              {
                                  msg: "Result is certified"
                              });
                          savebutton.hide();
                          certifybutton.hide();
                          resultfield.prop("disabled", true);


                      }
                      else
                      {
                          Lobibox.notify("error",
                              {
                                  msg: "Something Went wrong"
                              });

                      }
                  },
                  error: function (jqXHR, textStatus, errorThrown) {

                      Lobibox.alert("error",
                          {   width : 300,
                              msg: errorThrown
                          });

                  }



              });
          }


      });
      $(document).on('click', '#alpharectify' , function() {
          //code here ....
          var orderid = $(this).closest("tr").find('td:eq(4)').text();
          var result=$(this).closest("tr").find('#alpharesult').val();
          var savebutton= $(this).closest("tr").find('#alphasave');
          var certifybutton= $(this).closest("tr").find('#alphacertify');
          var resultfield=$(this).closest("tr").find('#alpharesult');
          if(result=='default'){
              Lobibox.notify("warning",
                  {
                      msg: "Choose a valid result"
                  });
          }
          else
          {
              $.ajax({
                  type:"post",
                  url:"<?php echo base_url().'result_processing/rectify_alpha_result'?>",
                  data :{
                      orderid:orderid,
                      result:result
                  },
                  datatype:"json",
                  success :function(response)
                  {
                      var response=JSON.parse(response);
                      if(response.status===true)
                      {
                          Lobibox.notify("success",
                              {
                                  msg: "Result is rectified"
                              });
                          savebutton.hide();
                          certifybutton.hide();
                          resultfield.prop("disabled", true);


                      }
                      else
                      {
                          Lobibox.notify("error",
                              {
                                  msg: "Something Went wrong"
                              });

                      }
                  },
                  error: function (jqXHR, textStatus, errorThrown) {

                      Lobibox.alert("error",
                          {   width : 300,
                              msg: errorThrown
                          });

                  }



              });
          }


      });


      $(document).on('change', '#numresult' , function() {

          var result=$(this).closest("tr").find('#numresult').val();
          var minrange= $(this).closest("tr").find('td:eq(9)').text();
          var maxrange=$(this).closest("tr").find('td:eq(10)').text();
          if(result<minrange || result>maxrange)
          {
              $(this).closest("tr").find('#numresult').addClass("highlightred");
          }
          else
          {
              $(this).closest("tr").find('#numresult').addClass("highlightgreen");
          }

      });
      $(document).on('change', '#alpharesult' , function() {

          var result=$(this).closest("tr").find('#alpharesult').val();
          if(result=='Positive' || result=='Undetermined')
          {
              $(this).closest("tr").find('#alpharesult').removeClass("highlightgreen");
              $(this).closest("tr").find('#alpharesult').addClass("highlightred");
          }
          else
          {
              $(this).closest("tr").find('#alpharesult').removeClass("highlightred");
              $(this).closest("tr").find('#alpharesult').addClass("highlightgreen");
          }

      });



    });


/*  $(document).on ('click','#resulttable tr',function() {
      var selected = $(this).closest("tr").hasClass("highlightred");
      $("#resulttable tr").closest("tr").removeClass("highlightred");
      if(!selected)
          $(this).closest("tr").addClass("highlightred");
  }); */


</script>

</html>
