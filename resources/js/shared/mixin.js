const Mixin = {
    data() {
      return {
        money: {
            decimal: ',',
            thousands: '.',
            prefix: 'R$ ',
            precision: 2,
            masked: false
        },
      }
    }
   };
 
   export default Mixin;