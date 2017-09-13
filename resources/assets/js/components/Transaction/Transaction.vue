<template>
    <div>
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                Ажил гүйлгээ
            </h1>
            <ol class="breadcrumb">
                <li><router-link to="/"><i class="fa fa-dashboard"></i> Удирдлага</router-link></li>
                <li class="active">Ажил гүйлгээ</li>
            </ol>
        </section>
        <transition name="slide">
            <router-view></router-view>
        </transition>
    </div>
</template>