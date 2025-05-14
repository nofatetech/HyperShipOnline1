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

  // Create elements from a template for each item in an array
  // example use of repeatingGroup:
  // xapp.repeatingGroup([], elementView, eleentTarget, extras);
  repeatingGroup(rdata, elementView, elementTarget, extras = {}) {
    console.log('repeatingGroup');
    if (!rdata || !Array.isArray(rdata)) {
      console.error('rdata must be an array');
      return;
    }

    if (!elementView || !elementTarget) {
      console.error('elementView and elementTarget are required');
      return;
    }

    // Clear existing content
    $(elementTarget).empty();

    // Create elements for each item in rdata
    rdata.forEach((item, index) => {
      // Clone the template element
      const element = $(elementView).clone();

      // // Add any extra classes or attributes from extras
      // if (extras.classes) {
      //   element.addClass(extras.classes);
      // }

      // Set data attributes if provided
      if (extras.dataAttributes) {
        Object.entries(extras.dataAttributes).forEach(([key, value]) => {
          element.attr(`data-${key}`, value);
        });
      }

      // Add index as data attribute
      element.attr('data-index', index);

      // Append to target
      $(elementTarget).append(element);
    });

    // Trigger a custom event after elements are created
    $(elementTarget).trigger('elements-created', [rdata]);

  }


}


