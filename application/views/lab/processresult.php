<!DOCTYPE html>
<style type="text/css">
    .table-border {
    }
</style>
<head>
<?php $this->load->view('includes/css');?>
    <style type="text/css">
        .table-nonfluid {
            width: auto;
            white-space: nowrap;
        }
    </style>
    <style type="text/css">


        </style>
</head>
<body>

<div>
    <?php $this->load->view('includes/logo'); ?>

    <!-- LOGO HEADER END-->
    <?php $this->load->view('includes/menu');?>
     <!-- MENU SECTION END-->
    <div class="content-wrapper">
        <div class="container-fluid">
             <div class="row pad-botm">
                 <div class="col-md-12 col-sm-12 col-xs-12 text-center">
                     <h6 class="header-line">Process Result</h6>

                     </div>

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
                                <label class="col-md-1 control-label text-sm">Fromdate</label>
                                <div class="col-md-2">
                                    <input id="frmdate" name="frmdate" type="date" placeholder="From Date"  class="form-control input-sm" value="<?php echo date('Y-m-d'); ?>" required >
                                </div>
                                <label class="col-md-1 control-label">Todate</label>
                                <div class="col-md-2">
                                    <input id="todate" name="todate" type="date" placeholder="To dateDate" class="form-control input-sm" value="<?php echo date('Y-m-d'); ?>" required>
                                </div>
                                <label class="col-md-1 control-label">Status</label>
                                <div class="col-md-2">
                                    <select id="status" name="status" class="input-sm" >
                                        <option value="2">Sample Recieved</option>
                                        <option value="3">Result Saved</option>
                                        <option value="4">Certified</option>
                                        <option value="5">Rectified</option>

                                        </select>
                                </div>

                                <div class="col-md-2 center-block">
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
                            <div class="table-responsive" >
                                <table  class="table-nonfluid table table-bordered tablesorter-green" id="resulttable">
                                    <thead>
                                    <tr>

                                        <th >Patient</th>
                                        <th>Lab_No </th>
                                        <th>Service</th>
                                        <th class="hidden">Order_ID</th>
                                        <th>SampleID</th>
                                        <th>ToRange</th>
                                        <th>FromRange</th>
                                        <th class="hidden">Alpha Normal</th>
                                        <th data-sort="string">Unit</th>
                                        <th>Method</th>
                                        <th>Priority</th>
                                        <th>Result</th>
                                        <th>Process_Result</th>
                                        <th>Status</th>
                                        <th>Sample</th>
                                        <th>Container</th>
                                        <th>Ordered_date</th>
                                        <th>Ordered_By</th>
                                        <th>Recieved_date</th>
                                        <th>Recieved_by</th>
                                        <th>Result_saved_date</th>
                                        <th>Saved_By</th>
                                        <th>Certified_date</th>
                                        <th>Certfifed_by</th>
                                        <th>Rectified_date</th>
                                        <th>Rectified_by</th>


                                    </tr>


                                    </thead>
                                    <tbody>



                                    </tbody>
                                </table>
                            </div>

                        </div>
                    </div>

    </div>
                <div class="col-md-6 col-lg-6 right-div" >
                  Result Legend: <label class="highlightblue label">Result is low </label>
                    <label class="highlightgreen label">Normal Result </label>
                    <label class="highlightred label">Result is high </label>
                    <div class="panel panel-warning">
                        <div class="panel-body col-md-12 ">


                        </div>

                    </div>

                </div>
</div>


     <!-- CONTENT-WRAPPER SECTION END-->
<?php $this->load->view('includes/footer'); ?>
      <!-- FOOTER SECTION END-->
    <!-- JAVASCRIPT FILES PLACED AT THE BOTTOM TO REDUCE THE LOADING TIME  -->
    <!-- CORE JQUERY  -->
    <?php $this->load->view('includes/js');?>
</body>
<script>
  $(document).ready(function(){

      $(function(){
          $("table#resulttable").tablesorter();
      });

       $("#search").submit(function(e)
       {
           e.preventDefault();
           $("#resulttable tbody tr").remove();
           var datastring=$("#search").serialize();

           $.ajax({
               type:"POST",
               url:"<?php echo base_url().'result_processing/search'?>",
               data:datastring,
               datatype:"html",
               success:function(response)
               {
                   $("#resulttable tbody").append(response).trigger("update");

               }

           });

       });

      $(document).on('click', '#numsave' , function() {
          //code here ....
          var orderid = $(this).closest("tr").find('td:eq(3)').text();
          var result=$(this).closest("tr").find('#numresult').val();
          var method=$(this).closest("tr").find('#method').val();
          var savebutton= $(this).closest("tr").find('#numsave');
          alert(method);
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
                      result:result,
                      method:method
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
      $(document).on('click', '#numcertify' , function() {
          //code here ....
          var orderid = $(this).closest("tr").find('td:eq(3)').text();
          var result=$(this).closest("tr").find('#numresult').val();
          var method=$(this).closest("tr").find('#method').val();
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
                      result:result,
                      method:method
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
          var orderid = $(this).closest("tr").find('td:eq(3)').text();
          var result=$(this).closest("tr").find('#numresult').val();
          var method=$(this).closest("tr").find('#method').val();
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
                      result:result,
                      method:method
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
          var orderid = $(this).closest("tr").find('td:eq(3)').text();
          var result=$(this).closest("tr").find('#alpharesult').val();
          var method=$(this).closest("tr").find('#method').val();

          var savebutton= $(this).closest("tr").find('#alphasave');
          if(result==''){
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
                      result:result,
                      method:method
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
          var orderid = $(this).closest("tr").find('td:eq(3)').text();
          var result=$(this).closest("tr").find('#alpharesult').val();
          var method=$(this).closest("tr").find('#method').val();
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
                      result:result,
                      method:method
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
          var orderid = $(this).closest("tr").find('td:eq(3)').text();
          var result=$(this).closest("tr").find('#alpharesult').val();
          var method=$(this).closest("tr").find('#method').val();
          var savebutton= $(this).closest("tr").find('#alphasave');
          var certifybutton= $(this).closest("tr").find('#alphacertify');
          var resultfield=$(this).closest("tr").find('#alpharesult');
          if(result==''){
              Lobibox.notify("warning",
                  {
                      msg: "Please enter a result"
                  });
          }
          else
          {
              $.ajax({
                  type:"post",
                  url:"<?php echo base_url().'result_processing/rectify_alpha_result'?>",
                  data :{
                      orderid:orderid,
                      result:result,
                      method:method
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
          var minrange= $(this).closest("tr").find('td:eq(5)').text();
          var maxrange=$(this).closest("tr").find('td:eq(6)').text();
          if(result<minrange)
          {
              $(this).closest("tr").find('#numresult').removeClass("highlightgreen");
              $(this).closest("tr").find('#numresult').removeClass("highlightred");
              $(this).closest("tr").find('#numresult').addClass("highlightblue");
          }
          else if(result>maxrange)
          {
              $(this).closest("tr").find('#numresult').removeClass("highlightgreen");
              $(this).closest("tr").find('#numresult').removeClass("highlightblue");
              $(this).closest("tr").find('#numresult').addClass("highlightred");
          }
          else{
              $(this).closest("tr").find('#numresult').removeClass("highlightblue");
              $(this).closest("tr").find('#numresult').removeClass("highlightred");
              $(this).closest("tr").find('#numresult').addClass("highlightgreen");
          }

      });
      $(document).on('change', '#alpharesult' , function() {

          var result=$(this).closest("tr").find('#alpharesult').val();
          var normal=$(this).closest("tr").find('td:eq(7)').text();
          alert(normal);

          if(result!=normal)
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
      $(document).on('click', '#sampleid' , function() {

          var sampleid=$(this).closest("tr").find('#sampleid').text();
          alert(sampleid);
          var url="<?php echo base_url().'card/barcode/';?>";

          window.open(url+sampleid, 'popUpWindow', 'height=200,width=400,left=500,top=200,resizable=no,scrollbars=no,toolbar=no,menubar=no,location=no,directories=no,status=yes')

      });
      $(document).on('click', '#makereport' , function() {

          var orderid = $(this).closest("tr").find('td:eq(3)').text();

          var url="<?php echo base_url().'report/create/';?>";

          window.open(url+orderid, 'popUpWindow', 'height=300,width=600,left=500,top=200,resizable=no,scrollbars=no,toolbar=no,menubar=no,location=no,directories=no,status=yes')

      });
      $(document).on('click', '#viewreport' , function() {

          var orderid = $(this).closest("tr").find('td:eq(3)').text();

          var url="<?php echo base_url().'report/view/';?>";

          window.open(url+orderid)

      });
      $(document).on('click', '#ammendreport' , function() {

          var orderid = $(this).closest("tr").find('td:eq(3)').text();

          var url="<?php echo base_url().'report/ammend/';?>";

          window.open(url+orderid, 'popUpWindow', 'height=300,width=600,left=500,top=200,resizable=no,scrollbars=no,toolbar=no,menubar=no,location=no,directories=no,status=yes')

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
