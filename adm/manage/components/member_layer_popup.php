<script type="text/x-template" id="member-layer-popup-template">
  <div v-if="show" style="position: fixed; width: 100%; height: 100%; top: 0; bottom: 0; left: 0; right: 0; background: rgba(50,50,50,0.5); z-index: 100; ">
    <div style="position: relative; width: 100%; height: 100%;">
      <div style="position: absolute; width: 400px; height: 450px; top: 0; bottom: 0; left: 0; right: 0; margin: auto;" class="mdc-card">
        <div style="position: relative; width: 100%; height: 100%;">
          <div style="position: absolute; top: 0; left: 0; right: 0; width: 100%; height: 72px; padding: 16px;">
            <div class="input" style="position: relative; width: 100%; height: 100%; border-radius: 4px; padding-left: 40px; padding-right: 0;">
              <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="currentColor" style="position: absolute; top: 0; bottom: 0; left: 8px; margin: auto; color: rgb(150,150,150);"><path d="M15.5 14h-.79l-.28-.27C15.41 12.59 16 11.11 16 9.5 16 5.91 13.09 3 9.5 3S3 5.91 3 9.5 5.91 16 9.5 16c1.61 0 3.09-.59 4.23-1.57l.27.28v.79l5 4.99L20.49 19l-4.99-5zm-6 0C7.01 14 5 11.99 5 9.5S7.01 5 9.5 5 14 7.01 14 9.5 11.99 14 9.5 14z"/><path d="M0 0h24v24H0z" fill="none"/></svg>
              <input type="text" v-model="name" style="width: 100%; height: 100%; border: 0; outline: none;" placeholder="이름으로 검색"/>
            </div>
          </div>
          <div style="position: absolute; top: 72px; bottom: 64px; left: 0; right: 0; width: 100%; height: calc( 100% - 130px ); overflow-y: auto; border: 1px solid #efefef; border-left: 0; border-right: 0;">
            <button v-for="(member, index) in members" v-on:click="onSelect(member);" type="button" class="mdc-button" style="position: relative; display: block; width: 100% !important; height: 64px !important; padding: 8px;">
              <div style="position: absolute; left: 16px; top: 0; bottom: 0; margin: auto; height: 48px;">
                <div style="position: relative; height: 24px; line-height: 24px; vertical-align: middle; text-align:left; padding-left: 24px;">
                  {{ member.name }}
                  <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="currentColor" style="position: absolute; left: 0; top: 6px; bottom: 6px;"><path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/><path d="M0 0h24v24H0z" fill="none"/></svg>
                </div>
                <div style="position: relative; height: 24px; line-height: 24px; vertical-align: middle; text-align:left; font-size: 10px; color: rgb(150,150,150); padding-left: 24px; text-transform: initial; ">
                  {{ member.id }}
                  <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="currentColor" style="position: absolute; left: 0; top: 6px; bottom: 6px;"><path d="M12 5.9c1.16 0 2.1.94 2.1 2.1s-.94 2.1-2.1 2.1S9.9 9.16 9.9 8s.94-2.1 2.1-2.1m0 9c2.97 0 6.1 1.46 6.1 2.1v1.1H5.9V17c0-.64 3.13-2.1 6.1-2.1M12 4C9.79 4 8 5.79 8 8s1.79 4 4 4 4-1.79 4-4-1.79-4-4-4zm0 9c-2.67 0-8 1.34-8 4v3h16v-3c0-2.66-5.33-4-8-4z"/><path d="M0 0h24v24H0z" fill="none"/></svg>
                </div>
              </div>
              <div style="position: absolute; right: 16px; top: 0; bottom: 0; margin: auto; height: 48px;">
                <div style="position: relative; height: 24px; line-height: 24px; vertical-align: middle; padding-right: 24px; text-align:right;">
                  {{ member.hphone }}
                  <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="currentColor" style="position: absolute; right:0; top: 6px; bottom: 6px;"><path d="M0 0h24v24H0z" fill="none"/><path d="M6.62 10.79c1.44 2.83 3.76 5.14 6.59 6.59l2.2-2.2c.27-.27.67-.36 1.02-.24 1.12.37 2.33.57 3.57.57.55 0 1 .45 1 1V20c0 .55-.45 1-1 1-9.39 0-17-7.61-17-17 0-.55.45-1 1-1h3.5c.55 0 1 .45 1 1 0 1.25.2 2.45.57 3.57.11.35.03.74-.25 1.02l-2.2 2.2z"/></svg>
                </div>
                <div style="position: relative; height: 24px; line-height: 24px; vertical-align: middle; padding-right: 24px; text-align:right; font-size: 10px; color: rgb(150,150,150); text-transform: initial;">
                  {{ member.email }}
                  <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="currentColor" style="position: absolute; right:0; top: 6px; bottom:6px;"><path d="M20 4H4c-1.1 0-1.99.9-1.99 2L2 18c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 4l-8 5-8-5V6l8 5 8-5v2z"/><path d="M0 0h24v24H0z" fill="none"/></svg>
                </div>
              </div>
            </button>
          </div>
          <div style="position: absolute; bottom: 0; left: 0; right: 0; width: 100%; height: 56px; font-size: 0;">
            <button v-on:click="cancel" class="mdc-button" type="button" style="display: inline-block; width: 50% !important; height: 56px !important;">취소</button>
            <button v-on:click="confirm" class="mdc-button" type="button" style="display: inline-block; width: 50% !important; height: 56px !important;">확인</button>
          </div>
          <div v-if="!members.length" style="position: absolute; width: 100%; height: 20px; top: 0; bottom: 0; left: 0; right: 0; margin: auto; text-align: center;">
            회원을 검색해 주세요.
          </div>
        </div>
      </div>
    </div>
  </div>
</script>
<script>

var popup_member = {
  data: {
    members: [],
    member: {},
    name: null,
    show: false
  }
};

Vue.data.member = popup_member.data.member;
Vue.created.push(function(){
  var appElement = document.getElementById("vue-app");
  appElement.appendChild(document.createElement("member-layer-popup"));
});
Vue.component('member-layer-popup', {
  template: "#member-layer-popup-template",
  data: function(){
    return popup_member.data;
  },
  methods: {
    cancel: function(){
      this.member = null;
      this.show = false;
    },
    confirm: function(){
      this.show = false;
      Vue.app.$data.member = this.member;
    },
    search: function(){
      var component = this;

      $.ajax({
        url: "/adm/manage/product/member_ajax.php",
        method: "post",
        data: {
          name: this.name
        },
        dataType: "json",
        success: function(res){
          component.members = res;
        }
      });
    },
    onSelect: function(member){
      this.member = member;
    }
  },
  watch: {
    name: function(){
      if(this.name.length) this.search();
    }
  }
});
</script>
