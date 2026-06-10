// Public copy of locaai.js for immediate use
document.addEventListener('DOMContentLoaded', function(){
  // Fade in animated elements
  document.querySelectorAll('.fade-in').forEach((el, i)=>{
    el.style.animationDelay = (i*40) + 'ms';
  });

  // Toggle nav on small screens
  const btn = document.querySelector('.nav-toggle');
  const nav = document.querySelector('.loca-nav');
  if(btn && nav){
    btn.addEventListener('click', ()=>{
      nav.style.display = (nav.style.display === 'flex') ? 'none' : 'flex';
    });
  }

  // Simple table row highlight on hover using JS for accessibility
  document.querySelectorAll('table tr').forEach(row=>{
    row.addEventListener('mouseenter', ()=> row.classList.add('fade-in'));
  });
});
