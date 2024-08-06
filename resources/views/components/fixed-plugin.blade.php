<div class="fixed-plugin">
    <a class="fixed-plugin-button text-dark position-fixed px-3 py-2">
        <i class="fa fa-shopping-basket py-2"></i>
    </a>
    <div class="card shadow-lg ">
      <div class="card-header pb-0 pt-3 ">
        <div class="{{ (Request::is('rtl') ? 'float-end' : 'float-start') }}">
          <h5 class="mt-3 mb-0">Request Manager</h5>
        </div>
        <div class="{{ (Request::is('rtl') ? 'float-start mt-4' : 'float-end mt-4') }}">
          <button class="btn btn-link text-dark p-0 fixed-plugin-close-button">
            <i class="fa fa-close"></i>
          </button>
        </div>
        <!-- End Toggle Button -->
      </div>
      <hr class="horizontal dark my-1">
      <div class="card-body pt-sm-3 pt-0">

        <hr class="horizontal dark my-sm-4">
        <a class="btn bg-gradient-dark w-100" href="/" target="_blank">Confirme your request</a>

      </div>
    </div>
  </div>
