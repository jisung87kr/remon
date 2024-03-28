document.addEventListener('alpine:init', () => {
  Alpine.store('rootModal', {
    show: false,
    toggle(){
      this.show = !this.show;
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
