window.addEventListener('beforeunload',()=>{document.querySelectorAll('.input').forEach(input=>input.value='')});
window.addEventListener('pagehide',()=>{document.querySelectorAll('.input').forEach(input=>input.value='')});
