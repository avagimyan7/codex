<div class="card card-elevated border-0 overflow-hidden">
  <div class="card-header bg-dark text-white fw-semibold">{{ $title ?? '' }}</div>
  <div class="card-body p-0">
    <div class="table-responsive">
      <table class="table table-striped align-middle mb-0 table-card">
        {{ $slot }}
      </table>
    </div>
  </div>
  @isset($footer)
    <div class="card-footer bg-white">{{ $footer }}</div>
  @endisset
</div>
