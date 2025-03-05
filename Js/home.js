function updateClock() {
    const now = new Date();
    

    const hours = now.getHours().toString().padStart(2, '0');
    const minutes = now.getMinutes().toString().padStart(2, '0');
    const seconds = now.getSeconds().toString().padStart(2, '0');
    const timeString = `${hours}:${minutes}:${seconds}`;
  

    const day = now.getDate().toString().padStart(2, '0');
    const month = (now.getMonth() + 1).toString().padStart(2, '0'); 
    const year = now.getFullYear();
    const dateString = `${day}/${month}/${year}`;
  

    document.getElementById('time').textContent = timeString;
    document.getElementById('date').textContent = dateString;
  }
  

  setInterval(updateClock, 1000);
  
 
  updateClock();

  function openPage(pageUrl) {
    window.location.href = pageUrl;
  }

  if (localStorage.getItem('loggedIn') !== 'true') {
      window.location.href = 'login.html';
  }
