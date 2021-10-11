<!DOCTYPE HTML>
<html>
<head>

    <script src="<?=base_url()?>media/js/dist/Chart.js"></script>
    <script src="<?=base_url()?>media/js/utils.js"></script>

    <?php

$this->load->view("includes/header_" . $this->session->userdata('usermodule'));
$this->load->view("includes/topbar_notsearch");
?>
    <script type="text/javascript">
        jQuery(document).ready(function () {
            $("#prj_id").chosen({
                allow_single_deselect: true
            });

        });

    </script>

    <style type="text/css">
        @media(max-width:1920px) {
            .topup {
                margin-top: 0px;
            }
        }

        @media(max-width:360px) {
            .topup {
                margin-top: 0px;
            }
        }

        @media(max-width:790px) {
            .topup {
                margin-top: 100px;
            }
        }

        @media(max-width:768px) {
            .topup {
                margin-top: -10px;
            }
        }
    </style>

    <div id="page-wrapper">
        <div class="main-page">
            <div class="table">
                <div class="col-md-12 widget-shadow" data-example-id="basic-forms" style="text-align:center">
                    <h1>Home Lands Holding ( Pvt ) Ltd. <br/> Market Surveyor Reports. </h1>
                </div>
            
            <div class="row">
                <div class="col-md-12 widget-shadow" data-example-id="basic-forms">
                    <div class="form-title">
                        <h4>Basic Information :</h4>
                    </div>
                    <div class="form-body">
                        <div class="form-inline">
                                <span>Property (ඉඩම් ව්‍යාපෘතිය ) </span>
                                <br/>                                
                                Property One 1
                        </div>
                        <hr />
                        <div class="form-inline">
                            <span>Branch (ශාඛාව) </span>
                            <br/>
                            Select Branch
                        </div>

                        <hr />
                        <div class="form-inline">
                        <span>Officer Name 	නිලධාරියාගේ නම </span>
                            <br/>
                            JANAKA&nbsp; CHAMPIKA
                        </div>
                        
                    </div>


                    <div class="form-title">
                        <h4>Land Details :</h4>
                    </div>
                    <div class="form-body">
                        <div class="form-inline">
                                <span>Land Extent (ඉඩම් ) </span>
                                <br/>                                
                                560 perch
                        </div>
                        <hr />                        
                        
                    </div>

                    <div class="form-title">
                        <h4>Location Of the Land / Marketability <br/> (ඉඩම පිහිටි ස්ථානය / ඉඩම විකිණිමට ඇති හැකියාව) </h4>
                    </div>
                    
                        <div class="form-inline">
                        අවට ඇති අනෙකුත් ඉඩම් ව්‍යාපෘති සහ විකිණිමට ඇති
                        පෞද්ගලික හිමි කරුවන්ගේ ඉඩම්වල දත්ත සහ එම ඉඩම්වලට අපගේ ඉඩමේ සිට ඇති
                        දුර සහ එම ඉඩම්වල සිට ප්‍රධාන මාර්ගවලට ඇති දුර
                        ( අවට ඇති ඉඩම්වල විකුණුන කොටස් ගනණ සහ ඉතිරිව ඇති කොටස් ගණන සහ ඒවායේ
                        මිලගණන් හා දුරකථන අංක
                        </div>
                        <hr /> 
                        
                        <div class="form-body">
                            <div class="form-inline">
                                <span> Distance to main roads, Schools, Hospital And Government & Privet Institutes  (ඉඩම් ) </span>
                                <br/>                                
                                Lorem Ipsum is simply dummy text of the printing and typesetting industry. 
                                Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when
                                an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.
                            </div>
                            <hr />                        
                        </div>
                        
                       
                        
                    </div>                  
                    


                </div>
            </div>


            
            </div>
        </div>
    </div>





    <!--footer-->
    <?
$this->load->view("includes/footer");
?>