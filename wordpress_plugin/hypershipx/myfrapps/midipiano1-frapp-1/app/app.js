class App {

  xcustom = {
    xlogin: {
      xemail: '',
      xpassword: '',
    }
  }

  constructor(xcustom = null) {
    if (xcustom) {
      this.xcustom = xcustom;
    }
    this.init();
  }
  // static getInstance() {
  //   if (!App.instance) {
  //     App.instance = new App();
  //   }
  //   return App.instance;
  // }

  init() {
    console.log('App initialized');

    this.initGSAP();
  }

  initGSAP() {
    console.log('GSAP initialized');
  }

  test() {
    console.log('test');
  }
}


