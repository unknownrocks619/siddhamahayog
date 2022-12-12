<div class="card mb-4">
    <div class="card-header d-flex justify-content-between bg-light py-4">
        <h4>Enrolled Program</h4>
        <button type="button" class="btn btn-outline-primary btn-sm" onclick="alert('You are not authorized to perform this action.')">
            <x-plus>
                Add to program
            </x-plus>
        </button>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-12">
                <table class="table table-hover table-bordered">
                    <thead>
                        <tr>
                            <th>
                                S.no
                            </th>
                            <th>
                                Program Name
                            </th>
                            <th>
                                Enrolled Date
                            </th>
                            <td>

                            </td>
                        </tr>
                    </thead>
                    <tbody>
                    <tbody>
                        <?php

                        use App\Models\Program;

                        $member->load(['member_detail' => function ($query) {
                            $query->with('program');
                        }]);
                        ?>
                        @forelse ($member->member_detail as $enrolled_program)
                        <tr>
                            <td>
                                {{ $loop->iteration }}
                            </td>
                            <td>
                                {{ $enrolled_program->program->program_name }}
                            </td>
                            <td>
                                {{ date("Y-m-d", strtotime($enrolled_program->created_at)) }}
                            </td>
                            <td>
                                <a href="#" class="btn btn-sm btn-outline-danger disabled" onclick="alert('You are not authorized to perform this action')">
                                    <x-trash>Revoke</x-trash>
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="text-center text-muted">Enrollment Not Found</td>
                        </tr>
                        @endforelse
                    </tbody>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<x-modal modal='enrollProgram'>
    <form action="{{-- route('center.admin.member.enroll_program',$member->id) --}}" method="post">
        @csrf
        <div class="modal-header">
            <h5 class="modal-title">
                Enroll User to Program
            </h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="programSelect">Program Select
                            <sup class="text-danger">*</sup>
                        </label>
                        <select name="program" id="program" class="form-control">
                            <?php
                            $programList = Program::where('status', 'active')->get();
                            ?>
                            @foreach ($programList as $program)
                            <option value="{{ $program->getKey() }}">
                                {{ $program->program_name }}
                            </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="section">
                                info
                            </label>
                            <div class="text-info fs-5">
                                Batch and Section will have default value. You do not have permission
                                to modify.
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <div class="row">
                <div class="col-md-12">
                    <button type="submit" class="btn btn-primary">
                        Enroll Now
                    </button>
                </div>
            </div>
        </div>
    </form>
</x-modal>