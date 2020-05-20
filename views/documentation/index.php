<?php

/* @var $this yii\web\View */
use yii\helpers\Url;
use yii\helpers\Html;

$this->title = 'Documentation';
?>
<div class="row doc-page">
  
<div class="col-md-2 doc-nav-block">
          <div class="box box-solid">
            <div class="box-header with-border">
              <h3 class="box-title"></h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body navigation">
                <div>
                  <a href="#introduction" class='link-introduction active'>
                  <i class="fa fa-circle-o"></i>
                    Introduction
                  </a>
                </div>
                <div>
                
                <a href="#modal-windows" class='link-modal-windows'>
                <i class="fa fa-circle-o"></i>
                  Modal Windows
                </a>
                </div>
                <div>
                <a href="#product-tours" class='link-product-tours'><i class="fa fa-circle-o"></i> Product Tours</a>
                </div>
                <div>
                <a href="#categories" class='link-categories'>
                <i class="fa fa-circle-o"></i>
                  Categories</a>
                </div>
                <div>
                <a href="#product-tour-admins" class='link-product-tour-admins'>
                <i class="fa fa-circle-o"></i>
                  Product tour Admins</a>
                </div>
                <div>
                <a href="#users" class='link-users'>
                <i class="fa fa-circle-o"></i>
                  Users</a>
                </div>
                <div>
                <a href="#api" class='link-api'> 
                <i class="fa fa-circle-o"></i>
                  API calls</a>
                </div>
                
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
  <div class="col-sm-9 doc-block" id="introduction">
    <div class="box box-primary">
      <div class="box-header with-border">
        <h3 class="box-title">Introduction</h3>
        <span class="label label-primary pull-right"><i class="fa fa-html5"></i></span>
      </div><!-- /.box-header -->
      <div class="box-body">
        <p class="doc-text">
          <b>Checker Help Launcher</b> it is application for help checker user understand how Checker works. 
          In this admin panel we allow create and update Items related to Checker Knowledge Base: Categories, Modal Windows, Product Tours.
        </p>
      </div><!-- /.box-body -->
    </div><!-- /.box -->
  </div>

  <div class="col-sm-9 doc-block" id="modal-windows">
    <div class="box box-primary" >
        <div class="box-header with-border">
          <h3 class="box-title">Modal Windows</h3>
          <span class="label label-primary pull-right"><i class="fa fa-html5"></i></span>
        </div><!-- /.box-header -->
        <div class="box-body">
        
          <p class="doc-text">
          <b>Create modal window</b><br/>
            Click on button "Create modal window" on <a href="https://learning-be.checker-soft.com/modal" target="_blank">Modal Windows</a> page
            <br/><br/>
            <img src="/img/doc/doc-modal-1.png"/>

            <b>Search Modal Window in List</b><br/>
            Click on button "Create modal window" on <a href="https://learning-be.checker-soft.com/modal" target="_blank">Modal Windows</a> page
            <br/><br/>
            <img src="/img/doc/doc-modal-1.png"/>

            <b >Update Modal Window</b><br/>
            Click on button "Create modal window" on <a href="https://learning-be.checker-soft.com/modal" target="_blank">Modal Windows</a> page
            <br/><br/>
            <img src="/img/doc/doc-modal-1.png"/>

            <b id="feature-announ">Feature announcement window</b><br/>
            Click on button "Create modal window" on <a href="https://learning-be.checker-soft.com/modal" target="_blank">Modal Windows</a> page
            <br/><br/>
            <img src="/img/doc/doc-modal-1.png"/>

          </p>
        </div><!-- /.box-body -->
      </div><!-- /.box -->
  </div>

  <div class="col-sm-9 doc-block" id="product-tours">
    <div class="box box-primary" >
        <div class="box-header with-border">
          <h3 class="box-title">Product Tours</h3>
          <span class="label label-primary pull-right"><i class="fa fa-html5"></i></span>
        </div><!-- /.box-header -->
        <div class="box-body">
          <p class="doc-text">
            <b>AdminLTE</b> is a popular open source WebApp template for admin dashboards and control panels.
            It is a responsive HTML template that is based on the CSS framework Bootstrap 3.
            It utilizes all of the Bootstrap components in its design and re-styles many
            commonly used plugins to create a consistent design that can be used as a user
            interface for backend applications. AdminLTE is based on a modular design, which
            allows it to be easily customized and built upon. This documentation will guide you through
            installing the template and exploring the various components that are bundled with the template.
          </p>
        </div><!-- /.box-body -->
      </div><!-- /.box -->
  </div>


  <div class="col-sm-9 doc-block" id="categories">
    <div class="box box-primary" >
        <div class="box-header with-border">
          <h3 class="box-title">Categories</h3>
          <span class="label label-primary pull-right"><i class="fa fa-html5"></i></span>
        </div><!-- /.box-header -->
        <div class="box-body">
          <p class="doc-text">
            <b>AdminLTE</b> is a popular open source WebApp template for admin dashboards and control panels.
            It is a responsive HTML template that is based on the CSS framework Bootstrap 3.
            It utilizes all of the Bootstrap components in its design and re-styles many
            commonly used plugins to create a consistent design that can be used as a user
            interface for backend applications. AdminLTE is based on a modular design, which
            allows it to be easily customized and built upon. This documentation will guide you through
            installing the template and exploring the various components that are bundled with the template.
          </p>
        </div><!-- /.box-body -->
      </div><!-- /.box -->
  </div>

  <div class="col-sm-9 doc-block" id="product-tour-admins">
    <div class="box box-primary" >
        <div class="box-header with-border">
          <h3 class="box-title">Product tour Admins</h3>
          <span class="label label-primary pull-right"><i class="fa fa-html5"></i></span>
        </div><!-- /.box-header -->
        <div class="box-body">
          <p class="doc-text">
            <b>AdminLTE</b> is a popular open source WebApp template for admin dashboards and control panels.
            It is a responsive HTML template that is based on the CSS framework Bootstrap 3.
            It utilizes all of the Bootstrap components in its design and re-styles many
            commonly used plugins to create a consistent design that can be used as a user
            interface for backend applications. AdminLTE is based on a modular design, which
            allows it to be easily customized and built upon. This documentation will guide you through
            installing the template and exploring the various components that are bundled with the template.
          </p>
        </div><!-- /.box-body -->
      </div><!-- /.box -->
  </div>

  <div class="col-sm-9 doc-block"  id="users">
    <div class="box box-primary">
        <div class="box-header with-border">
          <h3 class="box-title">Users</h3>
          <span class="label label-primary pull-right"><i class="fa fa-html5"></i></span>
        </div><!-- /.box-header -->
        <div class="box-body">
          <p class="doc-text">
            <b>AdminLTE</b> is a popular open source WebApp template for admin dashboards and control panels.
            It is a responsive HTML template that is based on the CSS framework Bootstrap 3.
            It utilizes all of the Bootstrap components in its design and re-styles many
            commonly used plugins to create a consistent design that can be used as a user
            interface for backend applications. AdminLTE is based on a modular design, which
            allows it to be easily customized and built upon. This documentation will guide you through
            installing the template and exploring the various components that are bundled with the template.
          </p>
        </div><!-- /.box-body -->
      </div><!-- /.box -->
  </div>

  <div class="col-sm-9 doc-block"  id="api">
    <div class="box box-primary">
        <div class="box-header with-border">
          <h3 class="box-title">API calls</h3>
          <span class="label label-primary pull-right"><i class="fa fa-html5"></i></span>
        </div><!-- /.box-header -->
        <div class="box-body">
          <p class="doc-text">
            <b>AdminLTE</b> is a popular open source WebApp template for admin dashboards and control panels.
            It is a responsive HTML template that is based on the CSS framework Bootstrap 3.
            It utilizes all of the Bootstrap components in its design and re-styles many
            commonly used plugins to create a consistent design that can be used as a user
            interface for backend applications. AdminLTE is based on a modular design, which
            allows it to be easily customized and built upon. This documentation will guide you through
            installing the template and exploring the various components that are bundled with the template.
          </p>
        </div><!-- /.box-body -->
      </div><!-- /.box -->
  </div>
</div>