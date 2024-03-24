document.addEventListener('alpine:init', () => {
  Alpine.store('rootModal', {
    show: false,
    toggle(){
      this.show = !this.show;
    }
  });

  Alpine.data('likeCampaignData', () => ({
    init(){
      this.isActive = this.$el.getAttribute('data-campaignId');
    },
    isActive: false,
    toggle(campaignId){
      if(this.isActive){
        this.isActive = false;
      } else {
        this.isActive = true;
      }
    },
  }));
});
