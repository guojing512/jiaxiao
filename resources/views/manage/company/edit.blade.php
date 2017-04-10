@extends('manage.common.layout')
@section('content')
      <style type="text/css">
        .isshow_input .input{width:22px;height:15px;margin-top:10px;}
      </style>
    <form method="post">
      {{ csrf_field() }}
      <input type="hidden" name="id" value="{{$info['id']}}" />
      <div class="vr_keyg">
        <p><span  class="qian">机构名称</span>
          <i class="require">*</i>
          <input type="text" name="company_name" value="{{ old('company_name')?old('company_name'):$info['company_name'] }}" placeholder="请输入机构名称" />
          {{$errors->first('company_name')}}
        </p>
        <p><span class="qian">机构类型</span>
          <i class="require">*</i>
          <select name="company_type" style="width: 252px;height: 35px;margin-left: 7px;">
            <option value="">请选择机构</option>
            <option value="1" @if($info['company_type'] == "1") selected @endif>驾校</option>
          </select>
          {{$errors->first('company_type')}}
        </p>

        <p><span class="qian">省份</span>
          <i class="require">*</i>
          <select name="province_id" style="width: 252px;height: 35px;margin-left: 7px;">
            <option value="">----省----</option>
            @foreach($province as $key=>$item)
              <option value="{{$item['id']}}" @if($info['province_id'] == $item['id']) selected @endif>{{$item['city_name']}}</option>
            @endforeach
          </select>
          {{$errors->first('province_id')}}
        </p>
        <p><span class="qian">城市</span>
          <i class="require">*</i>
          <select name="city_id" style="width: 252px;height: 35px;margin-left: 7px;">
            <option value="">----市----</option>
              @foreach($city as $key=>$item)
                  <option value="{{$item['id']}}" @if($info['city_id'] == $item['id']) selected @endif>{{$item['city_name']}}</option>
              @endforeach
          </select>
          {{$errors->first('city_id')}}
        </p>
        <p><span class="qian">区或县</span>
          <i class="require">*</i>
          <select name="county_id" style="width: 252px;height: 35px;margin-left: 7px;">
            <option value="">----区/县----</option>
              @foreach($county as $key=>$item)
                  <option value="{{$item['id']}}" @if($info['county_id'] == $item['id']) selected @endif>{{$item['city_name']}}</option>
              @endforeach
          </select>
          {{$errors->first('county_id')}}
        </p>


        <p><span  class="qian">详细地址</span>
          <input type="text" name="address" value="{{ old('address')?old('address'):$info['address'] }}" placeholder="请输入详细地址" />
        </p>
          <p><span class="qian">状态</span>
              <span class="isshow_input"><input class="input" name="is_del" type="radio" value="1" @if($info['is_del'] == '1') checked="checked"@endif/>启用</span>
              <span class="isshow_input"><input class="input" name="is_del" type="radio" value="0" @if($info['is_del'] == '0') checked="checked"@endif/>冻结</span>
              <br/>
          </p>
        <div class="zy_keybutton">
          <input type="submit" class="btn1" value="修改" /><input type="reset" class="btn2" value="取消" />
        </div>
      </div>
    </form>
      <script>
          $(document).ready(function(){
              $("select[name='province_id']").change(function(){
                  getCityOption($(this).val());
              });
          });
          function getCityOption(province_id){
              $.ajax({
                  type: "POST",
                  url:'{{url('company/getCityOption')}}',
                  data: "parent_id="+province_id,
                  dataType:'json',
                  success: function(serverJson){
                      if(serverJson.status){
                          $("select[name='city_id'] option").remove();
                          $("select[name='city_id']").append("<option value=''>----市----</option>");
                          $("select[name='county_id'] option").remove();
                          $("select[name='county_id']").append("<option value=''>----区/县----</option>");
                          for(key in serverJson.data){
                              var city = serverJson.data[key];
                              $("select[name='city_id']").append("<option value='"+city.id+"'>"+city.city_name+"</option>");
                          }
                          $("select[name='city_id']").bind("change",function(){
                              setCounty(this);
                          });
                      }

                  }
              });
          }
          function setCounty(o){
              $city_id = $(o).val();
              $.ajax({
                  type: "POST",
                  url:'{{url('company/getCityOption')}}',
                  data: "parent_id="+$city_id,
                  dataType:'json',
                  success: function(serverJson){
                      if(serverJson.status){
                          $("select[name='county_id'] option").remove();
                          $("select[name='county_id']").append("<option value=''>----区/县----</option>");
                          for(key in serverJson.data){
                              var county = serverJson.data[key];
                              $("select[name='county_id']").append("<option value='"+county.id+"'>"+county.city_name+"</option>");
                          }
                      }

                  }
              });
          }
      </script>
@stop

