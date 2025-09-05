window.addEventListener("DOMContentLoaded", () => {
      const musica = document.getElementById("background-music");
      if (musica) musica.volume = 0.2;
    });

    function playClick(){
      const s = document.getElementById('click-sound');
      if(!s) return;
      s.currentTime = 0; s.volume = 0.5; s.play();
    }
    function playClickAndGo(event, url){
      event.preventDefault();
      const s = document.getElementById('click-sound');
      if(!s){ window.location.href = url; return; }
      s.currentTime = 0; s.volume = 0.5; s.play();
      const go = ()=> window.location.href = url;
      s.onended = go; setTimeout(go, 1000);
    }
    document.addEventListener('click', function iniciarMusica(){
      const m = document.getElementById("background-music");
      if (m && m.paused) m.play();
      document.removeEventListener('click', iniciarMusica);
    });

    // Modal
    function abrirModalLogin(){ 
      document.getElementById('modal-auth').style.display='flex'; 
      mostrarLogin();
    }
    function abrirModalRegistro(){ 
      document.getElementById('modal-auth').style.display='flex'; 
      mostrarRegistro();
    }
    function cerrarModalAuth(){ 
      document.getElementById('modal-auth').style.display='none'; 
    }
    function mostrarLogin(){
      document.getElementById('login-form').style.display='block';
      document.getElementById('registro-form').style.display='none';
    }
    function mostrarRegistro(){
      document.getElementById('login-form').style.display='none';
      document.getElementById('registro-form').style.display='block';
    }
    function loginUsuario(){
      const u = document.getElementById('login-usuario').value;
      const p = document.getElementById('login-password').value;
      console.log('Login:', u, p);
      cerrarModalAuth();
    }
    function registrarUsuario(){
      const u = document.getElementById('registro-usuario').value;
      const p = document.getElementById('registro-password').value;
      console.log('Registro:', u, p);
      cerrarModalAuth();
    }