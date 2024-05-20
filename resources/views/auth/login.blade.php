@extends('layouts.app')
@section('content')
<div class="form-structor">
	<div class="signup">
		<h2 class="form-title" id="signup">IMS</h2>
        <div class="card card-radius-shadow">
            <div class="card-header">
                <div class="card-tools">
                    <a target="_blank" href="{{asset('storage/manualBook/DokumentasiAlurSistemUser.pdf')}}" class="btn btn-info btn-sm" title="Download manual book here">
                        <i class="fas fa-book"></i>
                    </a>
                </div>
            </div>
            <div class="card-body" style="font-size: 11px">
                IMS merupakan sistem manajemen informasi barang barang operasional perusahaan yang menyediakan
                fasilitas-fasilitas untuk:
                    <ul>
                        <li>Mengelola aktifitas Permintaan barang yang sifatnya transaksional seperti Pulpen, Kertas, Materai dll.</li>
                        <li> Mengelola data yang sifatnya tranformasional guna mendukung proses yang baik dan sesuai
                            dengan regulasi yang berlaku diperusahaan dan menjaga proses supaya akurat sesuai dengan data
                            yang ada.</li>
                       
                    </ul>
            </div>
        </div>
	</div>
   
	<div class="login slide-up">
		<div class="center">
			<h2 class="form-title" id="login">Log in</h2>
            <form method="POST" action="{{ route('login') }}">
                @csrf
			<div class="form-holder">
                <input placeholder="NIK"  id="nik" style="font-size: 12px !important" type="nik" class="input @error('nik') is-invalid @enderror" name="nik" value="{{ old('nik') }}" required autocomplete="nik" autofocus>

                @error('nik')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
                <input placeholder="Password"  id="password"  style="font-size: 12px !important" type="password" class="input @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">

                @error('password')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
			</div>
            <button type="submit" class="submit-btn bg-core">
                {{ __('Login') }}
            </button>
        </form>
		</div>
	</div>

</div>

<style>
        
    @import url("https://fonts.googleapis.com/css?family=Fira+Sans");

    html,body {
        position: relative;
        min-height: 100vh;
        background-color: #E1E8EE;
        display: flex;
        align-items: center;
        justify-content: center;
        font-family: "Poppins";
    -webkit-font-smoothing: antialiased;
    -moz-osx-font-smoothing: grayscale;
    }

    .form-structor {
        background-color: #222;
        border-radius: 15px;
        height: 550px;
        width: 350px;
        position: relative;
        overflow: hidden;
        filter: drop-shadow(5px 5px 5px rgba(0,0,0,0.4));
        &::after {
            content: '';
            opacity: .8;
            position: absolute;
            top: 0;right:0;bottom:0;left:0;
            background-repeat: no-repeat;
            background-position: left bottom;
            background-size: 500px;
            background-image: url('https://images.unsplash.com/photo-1503602642458-232111445657?ixlib=rb-0.3.5&ixid=eyJhcHBfaWQiOjEyMDd9&s=bf884ad570b50659c5fa2dc2cfb20ecf&auto=format&fit=crop&w=1000&q=100');
        }
        
        .signup {
            position: absolute;
            top: 50%;
            left: 50%;
            -webkit-transform: translate(-50%, -50%);
            width: 90%;
            z-index: 5;
            -webkit-transition: all .3s ease;
            
            
            &.slide-up {
                top: 5%;
                -webkit-transform: translate(-50%, 0%);
                -webkit-transition: all .3s ease;
            }
            
            &.slide-up .form-holder,
            &.slide-up .submit-btn {
                opacity: 0;
                visibility: hidden;
            }
            
            &.slide-up .form-title {
                font-size: 1em;
                cursor: pointer;
            }
            
            &.slide-up .form-title span {
                margin-right: 5px;
                opacity: 1;
                visibility: visible;
                -webkit-transition: all .3s ease;
            }
            
            .form-title {
                color: #fff;
                font-size: 1.7em;
                text-align: center;
                
                span {
                    color: rgba(0,0,0,0.4);
                    opacity: 0;
                    visibility: hidden;
                    -webkit-transition: all .3s ease;
                }
            }
            
            .form-holder {
                border-radius: 15px;
                background-color: #fff;
                overflow: hidden;
                margin-top: 50px;
                opacity: 1;
                visibility: visible;
                -webkit-transition: all .3s ease;
                
                .input {
                    border: 0;
                    outline: none;
                    box-shadow: none;
                    display: block;
                    height: 30px;
                    line-height: 30px;
                    padding: 8px 15px;
                    border-bottom: 1px solid #eee;
                    width: 100%;
                    font-size: 12px;
                    
                    &:last-child {
                        border-bottom: 0;
                    }
                    &::-webkit-input-placeholder {
                        color: rgba(0,0,0,0.4);
                    }
                }
            }
            
            .submit-btn {
                background-color:#6B92A4!important;
                color: white ;
                /* color: rgba(256,256,256,0.7); */
                border:0;
                border-radius: 15px;
                display: block;
                margin: 15px auto; 
                padding: 5px 25px;
                width: 100%;
                font-size: 13px;
                font-weight: bold;
                cursor: pointer;
                opacity: 1;
                visibility: visible;
                -webkit-transition: all .3s ease;
                
                &:hover {
                    transition: all .3s ease;
                    background-color: rgb(14, 162, 147);
                }
            }
        }
        
        .login {
            position: absolute;
            top: 20%;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: #fff;
            z-index: 5;
            -webkit-transition: all .3s ease;
            
            &::before {
                content: '';
                position: absolute;
                left: 50%;
                top: -20px;
                -webkit-transform: translate(-50%, 0);
                background-color: #fff;
                width: 200%;
                height: 250px;
                border-radius: 50%;
                z-index: 4;
                -webkit-transition: all .3s ease;
            }
            
            .center {
                position: absolute;
                top: calc(50% - 10%);
                left: 50%;
                -webkit-transform: translate(-50%, -50%);
                width: 65%;
                z-index: 5;
                -webkit-transition: all .3s ease;
                
                .form-title {
                    color: #000;
                    font-size: 1.7em;
                    text-align: center;

                    span {
                        color: rgba(0,0,0,0.4);
                        opacity: 0;
                    visibility: hidden;
                    -webkit-transition: all .3s ease;
                    }
                }

                .form-holder {
                    border-radius: 15px;
                    background-color: #fff;
                    border: 1px solid #eee;
                    overflow: hidden;
                    margin-top: 50px;
                    opacity: 1;
                    visibility: visible;
                    -webkit-transition: all .3s ease;

                    .input {
                        border: 0;
                        outline: none;
                        box-shadow: none;
                        display: block;
                        height: 30px;
                        line-height: 30px;
                        padding: 8px 15px;
                        border-bottom: 1px solid #eee;
                        width: 100%;
                        font-size: 12px;

                        &:last-child {
                            border-bottom: 0;
                        }
                        &::-webkit-input-placeholder {
                            color: rgba(0,0,0,0.4);
                        }
                    }
                }

                .submit-btn {
                    background-color: #6B92A4;
                    color: rgba(256,256,256,0.7);
                    border:0;
                    border-radius: 15px;
                    display: block;
                    margin: 15px auto; 
                    padding: 15px 45px;
                    width: 100%;
                    font-size: 13px;
                    font-weight: bold;
                    cursor: pointer;
                    opacity: 1;
                    visibility: visible;
                    -webkit-transition: all .3s ease;

                    &:hover {
                        transition: all .3s ease;
                        background-color: rgb(14, 162, 147);
                    }
                }
            }
            
            &.slide-up {
                top: 90%;
                -webkit-transition: all .3s ease;
            }
            
            &.slide-up .center {
                top: 10%;
                -webkit-transform: translate(-50%, 0%);
                -webkit-transition: all .3s ease;
            }
            
            &.slide-up .form-holder,
            &.slide-up .submit-btn {
                opacity: 0;
                visibility: hidden;
                -webkit-transition: all .3s ease;
            }
            
            &.slide-up .form-title {
                font-size: 1em;
                margin: 0;
                padding: 0;
                cursor: pointer;
                -webkit-transition: all .3s ease;
            }
            
            &.slide-up .form-title span {
                margin-right: 5px;
                opacity: 1;
                visibility: visible;
                -webkit-transition: all .3s ease;
            }
        }
    }
</style>
<script>
    console.clear();
    const loginBtn = document.getElementById('login');
    const signupBtn = document.getElementById('signup');

    loginBtn.addEventListener('click', (e) => {
        let parent = e.target.parentNode.parentNode;
        Array.from(e.target.parentNode.parentNode.classList).find((element) => {
            if(element !== "slide-up") {
                parent.classList.add('slide-up')
            }else{
                signupBtn.parentNode.classList.add('slide-up')
                parent.classList.remove('slide-up')
            }
        });
    });

    signupBtn.addEventListener('click', (e) => {
        let parent = e.target.parentNode;
        Array.from(e.target.parentNode.classList).find((element) => {
            if(element !== "slide-up") {
                parent.classList.add('slide-up')
            }else{
                loginBtn.parentNode.parentNode.classList.add('slide-up')
                parent.classList.remove('slide-up')
            }
        });
    });
</script>
@endsection