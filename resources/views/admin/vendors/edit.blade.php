@extends('layouts.admin')
@section('title','edit category')
@section('content')
<div class="app-content content">
        <div class="content-wrapper">
            <div class="content-header row">
                <div class="content-header-left col-md-6 col-12 mb-2">
                    <div class="row breadcrumbs-top">
                        <div class="breadcrumb-wrapper col-12">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="">الرئيسية </a>
                                </li>
                                <li class="breadcrumb-item"><a href=""> الاقسام الرئيسية </a>
                                </li>
                                <li class="breadcrumb-item active">تعديل متجر
                                </li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <div class="content-body">
                <!-- Basic form layout section start -->
                <section id="basic-form-layouts">
                    <div class="row match-height">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title" id="basic-layout-form"> تعديل متجر </h4>
                                    <a class="heading-elements-toggle"><i
                                            class="la la-ellipsis-v font-medium-3"></i></a>
                                    <div class="heading-elements">
                                        <ul class="list-inline mb-0">
                                            <li><a data-action="collapse"><i class="ft-minus"></i></a></li>
                                            <li><a data-action="reload"><i class="ft-rotate-cw"></i></a></li>
                                            <li><a data-action="expand"><i class="ft-maximize"></i></a></li>
                                            <li><a data-action="close"><i class="ft-x"></i></a></li>
                                        </ul>
                                    </div>
                                </div>
                                @include('admin.includes.alerts.success')
                                @include('admin.includes.alerts.errors')
                                <div class="card-content collapse show">
                                    <div class="card-body">
                                        <form class="form" action="{{route('admin.vendors.update',$vendors->id)}}" method="POST"enctype="multipart/form-data">
                                            @csrf
                                            <div class="form-group">
                                                <div class="text-center">
                                                    <img class="rounded-circle height-350" style="width:400px;height:400px" src="{{$vendors->logo}}" alt="">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label> لوجو التاجر </label>
                                                <label id="projectinput7" class="file center-block">
                                                    <input type="file" id="file" name="logo">
                                                    <span class="file-custom"></span>
                                                </label>
                                                @error("logo")
                                                    <span class="text-danger">{{$message}}</span>
                                                @enderror
                                            </div>
                                            <input name="id" value="{{$vendors->id}}" type="hidden">
                                            <div class="form-body">
                                                <h4 class="form-section"><i class="ft-home"></i> بيانات  المتجر </h4>
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="projectinput1">اسم المتجر</label>
                                                            <input type="text" value="{{$vendors->name}}" id="name"
                                                                   class="form-control"
                                                                   placeholder=""
                                                                   name="name">
                                                            @error("name")
                                                            <span class="text-danger">{{$message}}</span>
                                                            @enderror
                                                         </div>
                                                    </div>

                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="projectinput2"> اخترالقسم الرئيسى</label>
                                                            <select name="category_id" class="select2 form-control">
                                                                <optgroup label="من فضلك أختر القسم ">
                                                                    @if($categories && $categories->count() > 0)
                                                                        @foreach($categories as $category)
                                                                            <option value="{{$category->id}}" @if($vendors->category_id==$category->id) selected @endif >{{$category->name}}</option>
                                                                        @endforeach
                                                                    @endif
                                                                </optgroup>
                                                            </select>
                                                            @error("category_id")
                                                            <span class="text-danger">{{$message}}</span>
                                                            @enderror
                                                         </div>
                                                    </div>
                                                </div>



                                                <div class="row">

                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="projectinput1">رقم الهاتف</label>
                                                            <input type="text" value="{{$vendors->phone}}" id="phone"
                                                                   class="form-control"
                                                                   placeholder=""
                                                                   name="phone" >
                                                            @error("phone")
                                                            <span class="text-danger">{{$message}}</span>
                                                            @enderror
                                                         </div>
                                                    </div> 

                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="projectinput1">البريد الإلكترونى</label>
                                                            <input type="text" value="{{$vendors->email}}" id="email"
                                                                   class="form-control"
                                                                   placeholder=""
                                                                   name="email" >
                                                            @error("email")
                                                            <span class="text-danger">{{$message}}</span>
                                                            @enderror
                                                        </div>
                                                    </div>

                                                    
                                                </div>

                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="projectinput1">كلمة المرور</label>
                                                            <input type="password" value="" id="password"
                                                                   class="form-control"
                                                                   placeholder=""
                                                                   name="password" 
                                                                   >
                                                            @error("password")
                                                            <span class="text-danger">{{$message}}</span>
                                                            @enderror
                                                         </div>
                                                    </div> 
                                                </div>


                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group mt-1">
                                                            <input type="checkbox"  value="1"
                                                                   id="switcheryColor4"
                                                                   class="switchery" data-color="success"
                                                                   name="active"
                                                                   @if($vendors->active==1) checked @endif />
                                                            <label for="switcheryColor4"
                                                                   class="card-title ml-1">الحالة </label>

                                                            @error("active")
                                                            <span class="text-danger">{{$message}}</span>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="projectinput1">العنوان</label>
                                                            <input type="text" value="" id="pac-input"
                                                                   class="form-control"
                                                                   placeholder=""
                                                                   name="address" >
                                                            @error("address")
                                                            <span class="text-danger">{{$message}}</span>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                </div> -->
                                                
                                                <div id="map" style="width:900px;height:600px"></div>

                                            </div>

                                            <div class="form-actions">
                                                <button type="button" class="btn btn-warning mr-1"
                                                        onclick="history.back();">
                                                    <i class="ft-x"></i> تراجع
                                                </button>
                                                <button type="submit" class="btn btn-primary">
                                                    <i class="la la-check-square-o"></i> إضافة
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
                <!-- // Basic form layout section end -->
            </div>
        </div>
    </div>
</div>
@endsection
