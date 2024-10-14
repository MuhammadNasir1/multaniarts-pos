<!DOCTYPE html>
<html lang="en">
<?php

include_once 'includes/head.php';
?>
<style>
    .nav-list {
        font-size: 25px;
    }

    .bg-custom {
        background-color: #E1E1E1;
    }
</style>

<body class="horizontal light  ">
    <div class="wrapper">
        <?php include_once 'includes/header.php'; ?>

        <div class="container-fluid m-0 p-0">
            <div class="card m-0">
                <div class="card-header card-bg" align="center">
                    <div class="row">
                        <div class="col-12 mx-auto h4">
                            <b class="text-center card-text">Cutting</b>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class=" bg-white rounded shadow mb-5">
                        <ul id="myTab" role="tablist" class="nav nav-tabs nav-pills flex-column flex-sm-row text-center bg-custom border-0 rounded-nav">
                            <li class="nav-item flex-sm-fill">
                                <a id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="true" class="nav-link border-0 font-weight-bold active nav-list">From</a>
                            </li>
                            <li class="nav-item flex-sm-fill">
                                <a id="contact-tab" data-toggle="tab" href="#contact" role="tab" aria-controls="contact" aria-selected="false" class="nav-link border-0 font-weight-bold nav-list">To</a>
                            </li>
                        </ul>
                    </div>
                    <div id="myTabContent" class="tab-content">
                        <div id="profile" role="tabpanel" aria-labelledby="profile-tab" class="tab-pane fade px-4 py-5 show active">
                            <h1>From</h1>
                        </div>
                        <div id="contact" role="tabpanel" aria-labelledby="contact-tab" class="tab-pane fade px-4 py-5">
                            <h1>To</h1>
                        </div>
                    </div>
                </div>
            </div>
        </div>
</body>

</html>
<?php
include_once 'includes/foot.php';
?>