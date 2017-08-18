<template>
    <div>
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                Журнал
            </h1>
            <ol class="breadcrumb">
                <li><router-link to="/"><i class="fa fa-dashboard"></i> Удирдлага</router-link></li>
                <li class="active">Журнал</li>
            </ol>
        </section>
        <section class="content">
            <!-- Small boxes (Stat box) -->
            <div class="row">
                <div class="col-lg-4 col-md-5">
                    <div class="box">
                        <div class="box-header with-border">
                            <div class="box-title">
                                Журнал нэмэх
                            </div>
                        </div>
                        <div class="form-horizontal">
                            <div class="box-body">
                                <div class="form-group">
                                    <label class="col-sm-2 control-label">Нэр <label class="text-danger">*</label></label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" />
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-8 col-md-7">
                    <div class="box">
                        <div class="box-header with-border">
                            <div class="box-title">
                                Жагсаалт
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</template>