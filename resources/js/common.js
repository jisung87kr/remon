document.addEventListener('alpine:init', () => {
  Alpine.store('rootModal', {
    show: false,
    toggle(){
      this.show = !this.show;
    }
  });

  Alpine.store('menuModal', {
    show: false,
    toggle(){
      this.show = !this.show;
    }
  });

  Alpine.store('lnbModal', {
    show: false,
    open: false,
    init(){
      this.show =  window.innerWidth > 1024;
    },
    toggle(){
      this.open = !this.open;
    }
  });

  Alpine.data('favoriteCampaignData', () => ({
    isActive: false,
    init(){
      this.isActive = this.$el.getAttribute('data-campaignId') == 'true';
    },
    toggle(campaignId){
      if(this.isActive){
        axios.delete(`/api/user/favorites/campaigns/${campaignId}`).then(res => {
          console.log(res);
          this.isActive = false;
        });
      } else {
        axios.post(`/api/user/favorites/campaigns/${campaignId}`).then(res => {
          console.log(res);
          this.isActive = true;
        });
      }
    },
  }));
});

window.addEventListener('resize', () => {
  Alpine.store('lnbModal').show = window.innerWidth > 1024 ? true : false;
  Alpine.store('lnbModal').open = window.innerWidth > 1024 ? false : true;
});
