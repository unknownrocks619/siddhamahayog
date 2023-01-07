          <div class="col-md-9">
              <div class="alert alert-danger d-none" id="errorMessage"></div>
              <form id="vendantaRegistration" action="{{ route('vedanta.store') }}" method="post">
                  <div class="row mt-3">
                      <div class="col-md-12 d-flex justify-content-center">
                          <h2 class="theme-text fw-bold border-bottom pb-3">हिमालयन सिद्घमहायोग - वेदान्त दर्शन</h2>
                      </div>
                  </div>

                  <div class="row mt-4">
                      <p class="d-block text-center fs-3">
                          Your form for <code>Vedanta Darshan</code> has already been submitted.
                      </p>
                      <div class="col-md-12 d-flex justify-content-center">
                          <a data-href='{{ route("dashboard",["ref" => "_form"]) }}' href='{{ route("dashboard",["ref" => "_form"]) }}' class="clickable btn btn-success px-5 py-3 me-4">
                              <svg xmlns="http://www.w3.org/2000/svg" width="36" height="36" viewBox="0 0 24 24" style="fill: rgba(255, 255, 255, 1);transform: ;msFilter:;">
                                  <path d="M4 13h6a1 1 0 0 0 1-1V4a1 1 0 0 0-1-1H4a1 1 0 0 0-1 1v8a1 1 0 0 0 1 1zm-1 7a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1v-4a1 1 0 0 0-1-1H4a1 1 0 0 0-1 1v4zm10 0a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1v-7a1 1 0 0 0-1-1h-6a1 1 0 0 0-1 1v7zm1-10h6a1 1 0 0 0 1-1V4a1 1 0 0 0-1-1h-6a1 1 0 0 0-1 1v5a1 1 0 0 0 1 1z"></path>
                              </svg>
                              GO TO DASHBORD</a>
                          <?php
                            $transaction = auth()->user()->transactions()->first();

                            if (!$transaction || $transaction->rejected) {
                                echo "<a data-href='" . route("user.account.programs.program.index") . "' class=' clickable btn btn-danger px-5 py-3'>DEPOSIT ADMISSION FEE</a>";
                            }

                            if ($transaction && $transaction->amount < 9000) {
                                echo "<a data-href='" . route("user.account.programs.program.index") . "'  class='clickable btn btn-warning px-5 py-3'>PAY REMAINING FEE</a>";
                            }
                            ?>
                      </div>
                  </div>

              </form>
          </div>