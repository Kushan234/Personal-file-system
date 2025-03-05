
    const frameset = parent.document.getElementsByTagName('frameset')[0];


    function updateFramesetWidth() {
        const sidebarWidth = document.getElementById('sidemenu').offsetWidth;
        const contentWidth = window.innerWidth - sidebarWidth;
        frameset.cols = `${sidebarWidth},${contentWidth}`;
    }


    document.getElementById('sidemenu').addEventListener('mouseenter', updateFramesetWidth);
    document.getElementById('sidemenu').addEventListener('mouseleave', updateFramesetWidth);
