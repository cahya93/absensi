       <!-- Navigation-->
       <nav class="navbar navbar-expand-lg navbar-dark fixed-top" id="mainNav">
           <div class="container">
               <a class="navbar-brand js-scroll-trigger" href="<?= base_url(); ?>"><img src="<?= base_url(); ?>assets/frontend/assets/img/logo_baru.png" alt="" /></a>
               <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
                   Menu
                   <i class="fas fa-bars ml-1"></i>
               </button>
               <div class="collapse navbar-collapse" id="navbarResponsive">
                   <ul class="navbar-nav text-uppercase ml-auto">
                       <li class="nav-item"><a class="nav-link js-scroll-trigger" href="<?= base_url('home/kegiatan'); ?>">Kegiatan</a></li>
                       <li class="nav-item"><a class="nav-link js-scroll-trigger" href="<?= base_url('home/absen'); ?>">Absen</a></li>
                       <li class="nav-item"><a class="nav-link js-scroll-trigger" href="#contact">Kritik & Saran</a></li>
                       <li class="nav-item"><a class="nav-link js-scroll-trigger" href="<?= base_url('auth'); ?>">Login</a></li>
                   </ul>
               </div>
           </div>
       </nav>