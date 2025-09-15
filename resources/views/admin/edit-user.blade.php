<style>
  h5 {
    color: linear-gradient(269.87deg, #084095 2.99%, #108e16 96.59%);
  }

  h3 {
    color: linear-gradient(269.87deg, #084095 2.99%, #108e16 96.59%);
  }
  
</style>
<meta name="csrf-token" content="{{ csrf_token() }}">
@include('layouts.header')

@include('layouts.sidebar')
@include('layouts.top-navbar')
<div class="container">
  <div class="main-panel">
  <x-edit-user :user="$user" />
  </div>

</div>