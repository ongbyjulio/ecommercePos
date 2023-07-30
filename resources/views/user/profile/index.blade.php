@extends('layouts.ecommerce')
@section('content')



    <div class="container py-2 h-100">
        <figure class="text-center">
            <blockquote class="blockquote">
                <p>Data Profile</p>
            </blockquote>
            <figcaption class="blockquote-footer">
                My Profile <cite title="Source Title"></cite>

            </figcaption>
        </figure>
        <div class="row d-flex justify-content-center align-items-center h-100">
            <div class="col col-xl-10">

                @if ($errors->any())
                    <div class="alert alert-info">
                        @foreach ($errors->all() as $error)
                            <p>{{ $error }}</p>
                        @endforeach
                    </div>
                @endif


                <div class="card mb-5" style="border-radius: 15px;">


                    <div class="card-body p-4">
                        <h3 class="mb-3">Profile :</h3>
                        <p class="small mb-0"><i class="far fa-star fa-lg"></i> <span class="mx-2">|</span>
                            <strong>Name :</strong> <i>{{ $user->name }}</i>

                        </p>
                        <p class="small mb-0"><i class="far fa-star fa-lg"></i> <span class="mx-2">|</span>
                            <strong>Email :</strong> <i>{{ $user->email }}</i>
                        </p>
                        <p class="small mb-0"><i class="far fa-star fa-lg"></i> <span class="mx-2">|</span>
                            <strong>Address :</strong> <i>{{ $user->alamat }}</i>
                        </p>
                        <p class="small mb-0"><i class="far fa-star fa-lg"></i> <span class="mx-2">|</span>
                            <strong>Created at
                                on :</strong> <i>{{ $user->created_at }}</i>
                        </p>


                        <hr class="my-4">
                        <div class="d-flex justify-content-start align-items-center">

                            &nbsp; &nbsp;
                            <button type="button" class="btn btn-outline-dark btn-sm btn-floating" data-bs-toggle="modal"
                                data-bs-target="#modalUpdate">
                                <i class="fas fa-edit"> Update Profile</i>
                            </button>



                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    {{-- modal update --}}
    <div class="modal fade" id="modalUpdate" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">Update Profile</h5>

                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="col">

                        <form action="{{ route('update_profile', $user) }}" method="post">

                            @csrf

                            <div class="mb-3">
                                <label for="exampleFormControlInput1" class="form-label">Name</label>
                                <input type="text" name="name" class="form-control" value="{{ $user->name }}"
                                    id="exampleFormControlInput1" placeholder="name">
                            </div>

                            <div class="mb-3">
                                <label for="email" class="form-label">Email address</label>
                                <input type="text" name="email" id="email" class="form-control"
                                    value="{{ $user->email }}">
                            </div>

                            <div class="mb-3">
                                <label for="telpone" class="form-label">Telphone</label>
                                <input type="text" name="telp" id="telpone" class="form-control"
                                    value="{{ $user->telp }}">
                            </div>

                            <div class="mb-3 row">
                                <div class="mb-3">
                                    <label for="exampleFormControlTextarea2" class="form-label">Address</label>
                                    <textarea class="form-control" name="alamat" id="exampleFormControlTextarea2" rows="3">{{ $user->alamat }}</textarea>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="pass" class="form-label">Pass..</label>
                                <input type="password" name="password" id="pass" class="form-control"
                                    placeholder="New password">
                            </div>

                            <div class="mb-3">
                                <label for="password_confirmed" class="form-label">Conf..</label>
                                <input type="password" name="password_confirmation" id="password_confirmed"
                                    class="form-control" placeholder="Confirm new password">
                            </div>




                            <hr>
                            <div class="mb-3 text-start">
                                <button type="submit" class="btn btn-primary">Submit</button>
                                <button type="button" class="btn btn-dark" data-bs-dismiss="modal">Close</button>
                            </div>
                        </form>


                    </div>
                </div>
                <div class="modal-footer">

                </div>
            </div>
        </div>
    </div>

    {{-- modal update --}}
@endsection
