@if(session()->has('danger'))
  <div class="flash-message">
    <p class="alert alert-danger">
      {{ session()->get('danger') }}
    </p>
  </div>
@endif

@if(session()->has('warning'))
  <div class="flash-message">
    <p class="alert alert-warning">
      {{ session()->get('warning') }}
    </p>
  </div>
@endif

@if(session()->has('success'))
  <div class="flash-message">
    <p class="alert alert-success">
      {{ session()->get('success') }}
    </p>
  </div>
@endif

@if(session()->has('info'))
  <div class="flash-message">
    <p class="alert alert-info">
      {{ session()->get('info') }}
    </p>
  </div>
@endif
