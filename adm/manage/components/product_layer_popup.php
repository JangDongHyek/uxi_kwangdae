<script type="text/x-template" id="product-layer-popup-template">
  <div v-if="show" style="position: fixed; width: 100%; height: 100%; top: 0; bottom: 0; left: 0; right: 0; background: rgba(50,50,50,0.5); z-index: 100; "">
    <div style="position: relative; width: 100%; height: 100%;">
      <div style="position: absolute; width: 1200px; height: 800px; top: 0; bottom: 0; left: 0; right: 0; margin: auto;" class="mdc-card">
        <div style="position: relative; width: 100%; height: 100%;">
          <div style="position: absolute; width: 100%; height: calc( 100% - 65px ); top: 0; left: 0; right: 0; border-bottom: 1px solid #efefef;">
            <div style="position: absolute; width: 300px; height: 100%; top: 0; bottom: 0; left: 0;">
              <div style="position: absolute; width: 100%; height: 72px; top: 0; left: 0; right: 0; border-bottom: 1px solid #efefef; padding: 16px;">
                <div class="input" style="position: relative; width: 100%; height: 100%; border-radius: 4px; padding-left: 40px; padding-right: 0;">
                  <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="currentColor" style="position: absolute; top: 0; bottom: 0; left: 8px; margin: auto; color: rgb(150,150,150);"><path d="M15.5 14h-.79l-.28-.27C15.41 12.59 16 11.11 16 9.5 16 5.91 13.09 3 9.5 3S3 5.91 3 9.5 5.91 16 9.5 16c1.61 0 3.09-.59 4.23-1.57l.27.28v.79l5 4.99L20.49 19l-4.99-5zm-6 0C7.01 14 5 11.99 5 9.5S7.01 5 9.5 5 14 7.01 14 9.5 11.99 14 9.5 14z"/><path d="M0 0h24v24H0z" fill="none"/></svg>
                  <input type="text" v-model="prdname" style="width: 100%; height: 100%; border: 0; outline: none;" placeholder="상품 이름으로 검색"/>
                </div>
              </div>
              <div style="position: absolute; width: 100%; height: 100%; top: 72px; bottom: 0; left: 0; right: 0; ">
                <div style="position: relative; width: 100%; height: 100%; overflow-y: auto;">
                  <button v-for="(product, index) in products" v-on:click="onSelect(product)" type="button" class="mdc-button" style="position: relative; width: 100% !important; height: 72px !important;" >
                    <div style="position: absolute; left: 16px; top: 0; bottom: 0; margin: auto; height: 48px; ">
                      <img style="width: 48px; height: 48px;" v-bind:src="product.prdimg"/>
                    </div>
                    <div style="position: absolute; left: 84px; right: 12px; top: 0; bottom: 0; margin: auto; height: 48px;">
                      <div style="text-align: left;">{{ product.prdname }}</div>
                      <div style="text-align: left; font-size: 12px; color: rgb(150,150,150)">재고: {{ parseInt(product.stock).format() }}개</div>
                      <div style="text-align: left; font-size: 12px; color: rgb(150,150,150)">가격: {{ parseInt(product.price).format() }}원</div>
                    </div>
                    <div class="normal" v-bind:class="{ basketed: checkBasket(product) }" style="position: absolute; right: 0; top: 0; bottom: 0; width: 40px; height: 100%;">
                      <div style="position: relative; width: 100%; height: 100%; background-color: #1e88e5; color: white; ">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="currentColor" style="position: absolute; top: 0; bottom: 0; left: 0; right: 0; margin: auto;"><path fill="none" d="M0 0h24v24H0V0z"/><path d="M15.55 13c.75 0 1.41-.41 1.75-1.03l3.58-6.49c.37-.66-.11-1.48-.87-1.48H5.21l-.94-2H1v2h2l3.6 7.59-1.35 2.44C4.52 15.37 5.48 17 7 17h12v-2H7l1.1-2h7.45zM6.16 6h12.15l-2.76 5H8.53L6.16 6zM7 18c-1.1 0-1.99.9-1.99 2S5.9 22 7 22s2-.9 2-2-.9-2-2-2zm10 0c-1.1 0-1.99.9-1.99 2s.89 2 1.99 2 2-.9 2-2-.9-2-2-2z"/></svg>
                      </div>
                    </div>
                  </button>
                </div>
              </div>
              <div v-if="!products.length" style="position: absolute; width: 100%; height: 20px; top: 0; bottom: 0; left: 0; right: 0; margin: auto; text-align: center;">
                상품을 검색 해주세요.
              </div>
            </div>
            <div style="position: absolute; width: calc( 100% - 301px); height: 100%; top: 0; bottom: 0; right: 0; border-left: 1px solid #efefef; z-index: 99; padding: 32px;  background-color: #f5f5f5; overflow-y: auto;">
              <div v-if="selected" style="position: relative; width: 100%; height: 100%;">
                <div style="position: absolute; left: 0; top: 0; width: 40%; height: 100%;">
                  <img v-bind:src="selected.prdimg" class="mdc-card" style="width: 100%; height: auto;"/>
                </div>
                <div style="position: absolute; right: 0; top: 0; width: calc( 60% - 16px ); height: 100%;">
                  <div style="margin-bottom: 16px;">
                    <span style="display: inline-block; width: 100%; font-size: 24px; font-weight: 600; border-bottom: 1px solid rgb(100,100,100); padding-bottom: 16px;">{{ selected.prdname }}</span>
                  </div>
                  <div style="position: relative; padding-left: 96px;">
                    <span style="position: absolute; left: 0; top: 0; bottom: 0; display: inline-block; width: 96px; font-size: 14px; font-weight: 600; line-height: 40px;">대여기간</span>
                    <div style="position: relative; display: inline-block; width: 100%; font-size: 0;">
                      <label for="sdate" style="display: inline-block; width: 45%;">
                        <input v-model="selected.sdate" v-bind:id="'sdate'" type="text" class="input" style="width: 100%;" placeholder="대여시작"/>
                      </label>
                      <div style="display: inline-block; width: calc( 10% - 3px ); text-align:center; font-size: 14px; line-height: 40px; vertical-align: middle;">~</div>
                      <label for="edate" style="display: inline-block; width: 45%;">
                        <input v-model="selected.edate" v-bind:id="'edate'" type="text" class="input" style="width: 100%%;" placeholder="대여종료"/>
                      </label>
                    </div>
                  </div>
                  <div style="position: relative; padding-left: 96px;">
                    <span style="position: absolute; left: 0; top: 0; bottom: 0; display: inline-block; width: 96px; font-size: 14px; font-weight: 600; line-height: 40px;">배송방법</span>
                    <select v-model="selected.delivery" class="select" style="display: inline-block; width: 100%;">
                      <option value="">배송방법을 선택하세요.</option>
    									<option value="매장방문">매장방문</option>
    									<option value="퀵배송">퀵배송</option>
    									<option value="고속버스탁송">고속버스탁송</option>
    									<option value="택배">택배</option>
                    </select>
                  </div>
                  <div style="position: relative; margin-top: 16px; padding-left: 96px;">
                    <span style="position: absolute; left: 0; top: 0; bottom: 0; display: inline-block; width: 96px; font-size: 14px; font-weight: 600; line-height: 40px;">수량</span>
                    <div v-if="selected.stock" style="display: inline-block; width: 100%; ">
                      <button v-on:click="decAmount" class="mdc-button" type="button" style="min-width: 40px !important; height: 40px !important; padding: 0; color: black; border: 1px solid #dddddd;">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="currentColor"><path fill="none" d="M0 0h24v24H0V0z"/><path d="M19 13H5v-2h14v2z"/></svg>
                      </button>
                      <input v-model="selected.amount" class="input" style="width: 72px; text-align: center; padding: 0;"/>
                      <button v-on:click="incAmount" class="mdc-button" type="button" style="min-width: 40px !important; height: 40px !important; padding: 0; color: black; border: 1px solid #dddddd;">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="currentColor"><path fill="none" d="M0 0h24v24H0V0z"/><path d="M19 13h-6v6h-2v-6H5v-2h6V5h2v6h6v2z"/></svg>
                      </button>
                    </div>
                    <div v-if="!selected.stock">
                      재고없음
                    </div>
                  </div>
                  <div v-if="selected.supply_subjects" style="margin-top: 16px;">
                    <span style="display: inline-block; width: 96px; font-size: 14px; font-weight: 600; line-height: 40px;">옵션</span>
                    <div>
                      <div v-for="(supply_header, index) in selected.supply_subjects.split(',')" style="position: relative; padding-left: 96px;">
                        <span style="position: absolute; left: 16px; top: 0; bottom: 0; display: inline-block; width: 80px; text-align: left; line-height: 40px;">{{ supply_header }}</span>
                        <select v-model="selected.supply_values[index]" v-on:change="addOption(supply_header, index)" style="width: 100%;" >
                          <option value="" style="display: none;" selected></option>
                          <option v-for="(option, option_header) in selected.supply_table[supply_header]" v-bind:value="option_header">
                            {{ option_header }}
                          </option>
                        </select>
                      </div>
                    </div>
                    <div style="margin: 8px;"></div>
                    <div v-for="(option, index) in selected.option_table" class="mdc-card" style="position: relative; width: 100%; height: 48px; background-color: rgb(250,250,250); text-align: left; line-height: 48px; padding-left: 16px;">
                      {{ option.values }}
                      <button v-on:click="selected.option_table.splice(index, 1);" class="mdc-button" type="button" style="position: absolute; top: 0; bottom: 0; right: 0; color: rgb(100,100,100);">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="currentColor"><path d="M19 6.41L17.59 5 12 10.59 6.41 5 5 6.41 10.59 12 5 17.59 6.41 19 12 13.41 17.59 19 19 17.59 13.41 12z"/><path d="M0 0h24v24H0z" fill="none"/></svg>
                      </button>
                    </div>
                  </div>
                  <div style="margin-top: 16px; padding-top: 16px; border-top: 1px solid rgb(200,100,100);">
                    <span style="display: inline-block; width: 100%; font-size: 14px; font-weight: 600; margin-bottom: 8px; padding-bottom: 8px;">견적비용</span>
                    <div style="position: relative; width: 100%; height: 20px;">
                      <div style="position: absolute; display: inline-block; left: 0; top: 0; bottom: 0;">
                        연체시 <span style="color: rgb(200,100,100); font-weight: 600;">{{ parseInt(total * 0.4).format() }}</span>원
                      </div>
                      <div style="position: absolute; display: inline-block; right: 0; top: 0; bottom: 0;">
                        대여료 <span style="color: rgb(200,100,100); font-weight: 600;">{{ parseInt(total + (total * 0.2 * selected.day)).format() }}</span>원
                      </div>
                    </div>
                  </div>
                  <div style="margin-top: 16px; margin-bottom: 16px; text-align: right; padding-top: 16px; border-top: 1px solid rgb(100,100,100);">
                    <button v-on:click="addBasket()" v-bind:disabled="selected.basketed" type="button" class="mdc-button mdc-button--raised" style="margin: 2px; padding: 8px;">
                      <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="currentColor" style="margin-right: 4px;"><path fill="none" d="M0 0h24v24H0V0z"/><path d="M15.55 13c.75 0 1.41-.41 1.75-1.03l3.58-6.49c.37-.66-.11-1.48-.87-1.48H5.21l-.94-2H1v2h2l3.6 7.59-1.35 2.44C4.52 15.37 5.48 17 7 17h12v-2H7l1.1-2h7.45zM6.16 6h12.15l-2.76 5H8.53L6.16 6zM7 18c-1.1 0-1.99.9-1.99 2S5.9 22 7 22s2-.9 2-2-.9-2-2-2zm10 0c-1.1 0-1.99.9-1.99 2s.89 2 1.99 2 2-.9 2-2-.9-2-2-2z"/></svg>
                      추가하기
                    </button>
                    <button v-on:click="removeBasket()" v-bind:disabled="!selected.basketed" type="button" class="mdc-button mdc-button--raised removeBasket" style="margin: 2px; padding: 8px;">
                      <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="currentColor" style="margin-right: 4px;"><path fill="none" d="M0 0h24v24H0V0z"/><path d="M1.41 1.13L0 2.54l4.39 4.39 2.21 4.66-1.35 2.45c-.16.28-.25.61-.25.96 0 1.1.9 2 2 2h7.46l1.38 1.38c-.5.36-.83.95-.83 1.62 0 1.1.89 2 1.99 2 .67 0 1.26-.33 1.62-.84L21.46 24l1.41-1.41L1.41 1.13zM7 15l1.1-2h2.36l2 2H7zM20 4H7.12l2 2h9.19l-2.76 5h-1.44l1.94 1.94c.54-.14.99-.49 1.25-.97l3.58-6.49C21.25 4.82 20.76 4 20 4zM7 18c-1.1 0-1.99.9-1.99 2S5.9 22 7 22s2-.9 2-2-.9-2-2-2z"/></svg>
                      삭제하기
                    </button>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div style="position: absolute; width: 100%; height: 64px; bottom: 0; left: 0; right: 0;">
            <button v-on:click="confirm" class="mdc-button" type="button" style="width: 100% !important; height: 100% !important;">확인</button>
          </div>
        </div>
      </div>
    </div>
  </div>
</script>
<style>
.removeBasket:not(:disabled){
  background-color: rgb( 100, 100, 100 );
}
.normal{
  display: none;
}
.basketed{
  display: inline-block;
}
</style>
<script>

var popup_product = {
  data: {
    products: [],
    baskets: [],
    selected: null,
    prdname: null,
    show: false
  }
};

Vue.data.baskets = popup_product.data.baskets;
Vue.computed.price = function(){
  var price = 0;

  for(var i=0; i<this.baskets.length; i++){
    var product = this.baskets[i];
    var total = 0;
    var option_price = 0;
    for(var j in product.option_table){
      var option = product.option_table[j];
      option_price += parseInt(option.price);
    }
    price += (parseInt(product.price) + option_price) * product.amount;
  }

  return price;
};
Vue.computed.dueprice = function(){
  var price = 0;

  for(var i=0; i<this.baskets.length; i++){
    var product = this.baskets[i];
    var total = 0;
    var option_price = 0;
    for(var j in product.option_table){
      var option = product.option_table[j];
      option_price += parseInt(option.price);
    }
    price += (parseInt(product.price) + option_price) * product.amount * 0.2 * this.baskets[i].day;
  }

  return price;
};
Vue.created.push(function(){
  var appElement = document.getElementById("vue-app");
  appElement.appendChild(document.createElement("product-layer-popup"));
});

function pad(n, width) {
  n = n + '';
  return n.length >= width ? n : new Array(width - n.length + 1).join('0') + n;
};

Vue.component('product-layer-popup',{
  template: "#product-layer-popup-template",
  data: function(){
    return popup_product.data;
  },
  methods: {
    confirm: function(){
      this.show = false;
      // Vue.app.$data.products = this.products;
    },
    search: function(){

      var component = this;

      $.ajax({
        url: "/adm/manage/product/product_ajax.php",
        method: "post",
        data: {
          prdname: this.prdname
        },
        dataType: "json",
        success: function(res){
          component.$set(component.$data, "products", res);

          for(var i=0; i<component.products.length; i++){
            component.$set(component.products[i], "amount", 1 );
            component.$set(component.products[i], "supply_table", JSON.parse( (!component.products[i].supply_table) ? "{}" : component.products[i].supply_table ));
            component.$set(component.products[i], "supply_values", []);
            component.$set(component.products[i], "option_table", []);
            component.$set(component.products[i], "basketed", false );
            component.$set(component.products[i], "delivery", "" );
            component.$set(component.products[i], "sdate", "" );
            component.$set(component.products[i], "edate", "" );
            component.$set(component.products[i], "day", 0 );
          }
        }
      });
    },
    onSelect: function(product){
      for(var i=0; i<this.baskets.length; i++){
        if(this.baskets[i].prdcode == product.prdcode){
          this.$set(this.$data, "selected", this.baskets[i]);
          return;
        }
      }
      this.$set(this.$data, "selected", product);
    },
    addBasket: function(){
      if(this.selected){

        if(!this.selected.sdate || !this.selected.edate){
          alert("대여기간을 선택해 주세요.");
          return;
        }

        this.$set(this.selected, "basketed", true);
        this.$set(this.baskets, this.baskets.length, this.selected);
      }
    },
    removeBasket: function(){
      if(this.selected){
        this.$set(this.selected, "basketed", false);
        for(var i=0; i<this.baskets.length; i++){
          if(this.baskets[i] == this.selected){
            this.baskets.splice(i, 1);
          }
        }
      }
    },
    addOption: function(supply_header, index){
      if(this.selected && this.selected.supply_values[index]){
        var values = supply_header + "/" + this.selected.supply_values[index];
        var option = this.selected.supply_table[supply_header][this.selected.supply_values[index]];
        for(var i=0; i<this.selected.option_table.length; i++){
          if(this.selected.option_table[i] == values){
            alert("'"+ values +"' 옵션을 중복해서 넣을 수 없습니다.");
            return;
          }
        }

        this.$set(this.selected.option_table, this.selected.option_table.length , {
          type: 'supply',
          values: values,
          price: option.price,
          amount: 1
        });
      }
    },
    incAmount: function(){
      if(this.selected && this.selected.amount < this.selected.stock ){
        this.selected.amount ++;
      }
    },
    decAmount: function(){
      if(this.selected && this.selected.amount > 1){
        this.selected.amount --;
      }
    },
    checkBasket: function(product){
      for(var i=0;i<this.baskets.length; i++){
        if(this.baskets[i].prdcode == product.prdcode){
          return true;
        }
      }
      return false;
    }
  },
  watch: {
    prdname: function(){
      if(this.prdname.length) this.search();
    },
    selected: function(){

    }
  },
  computed: {
    total: function(){
      var total = 0;
      var option_price = 0;
      for(var i in this.selected.option_table){
        option_price += parseInt(this.selected.option_table[i].price);
      }
      if(this.selected){
        total = this.selected.amount * (parseInt(this.selected.price) + option_price);
      }
      return total;
    }
  },
  updated: function(){
    this.$nextTick(function(){

      var component = this;

      if(document.getElementById("sdate")){
        $("#sdate").datepicker({
          dateFormat: 'yy-mm-dd',
          dayNamesMin: ['일', '월', '화', '수', '목', '금', '토'],
          monthNamesShort: ['1월','2월','3월','4월','5월','6월','7월','8월','9월','10월','11월','12월'],
          changeMonth: true, // 월을 바꿀수 있는 셀렉트 박스를 표시한다.
          changeYear: true, // 년을 바꿀 수 있는 셀렉트 박스를 표시한다.
          showMonthAfterYear: true, // 년월 셀렉트 박스 위치 변경
          beforeShowDay: function(date){
            var edate = $("#edate").val();

            var today = new Date();
            today.setHours(0,0,0,0);

            if(date.getTime() < today.getTime()) return [false];

            if(!edate) return [true];
            else{
              var trd = new Date(edate);
              trd.setHours(0,0,0,0);
              trd.setDate(trd.getDate() - 2);
              if(date.getTime() <= trd.getTime()) return [true];
              else return [false];
            }
          },
          onSelect: function(date){
            var sdate = date;
            var edate = $("#edate").val();

            component.$set(component.selected, "sdate", date);

            if(sdate && edate){
              sdate = new Date(sdate);
              sdate.setHours(0,0,0,0);
              edate = new Date(edate);
              edate.setHours(0,0,0,0);

              // 연장일수
              // document.getElementById("day").value = (edate.getTime() - sdate.getTime()) / 86400000 - 2;
              component.$set(component.selected, "day", (edate.getTime() - sdate.getTime()) / 86400000 - 2);

              // updateTotalPrice();
            }
            else if(!edate){
              var trd = new Date(sdate);
    					trd.setDate(trd.getDate() + 2);


              component.$set(component.selected, "edate", [trd.getFullYear(), pad(trd.getMonth() + 1, 2), pad(trd.getDate(), 2)].join("-") );
            }
          }
        });
      }

      if(document.getElementById("edate")){
        $("#edate").datepicker({
          dateFormat: 'yy-mm-dd',
          dayNamesMin: ['일', '월', '화', '수', '목', '금', '토'],
          monthNamesShort: ['1월','2월','3월','4월','5월','6월','7월','8월','9월','10월','11월','12월'],
          changeMonth: true, // 월을 바꿀수 있는 셀렉트 박스를 표시한다.
          changeYear: true, // 년을 바꿀 수 있는 셀렉트 박스를 표시한다.
          showMonthAfterYear: true, // 년월 셀렉트 박스 위치 변경
          beforeShowDay: function(date){
            var sdate = $("#sdate").val();

            var today = new Date();
            today.setDate(today.getDate() + 2);
            today.setHours(0,0,0,0);

            if(date.getTime() < today.getTime()) return [false];

            if(!sdate) return [true];
            else{
              var trd = new Date(sdate);
              trd.setHours(0,0,0,0);
              trd.setDate(trd.getDate() + 2);
              if(trd.getTime() <= date.getTime()) return [true];
              else return [false];
            }
          },
          onSelect: function(date){
            var sdate = $("#sdate").val();
            var edate = date;

            component.$set(component.selected, "edate", date);

            if(sdate && edate){
              sdate = new Date(sdate);
              sdate.setHours(0,0,0,0);
              edate = new Date(edate);
              edate.setHours(0,0,0,0);

              // 연장일수
              // document.getElementById("day").value = (edate.getTime() - sdate.getTime()) / 86400000 - 2;
              component.$set(component.selected, "day", (edate.getTime() - sdate.getTime()) / 86400000 - 2);

              // updateTotalPrice();
            }
            else if(!sdate){
    					var trd = new Date(edate);
    					trd.setDate(trd.getDate() - 2);
              component.$set(component.selected, "sdate", [trd.getFullYear(), pad(trd.getMonth() + 1, 2), pad(trd.getDate(), 2)].join("-") );
            }
          }
        });
      }
    });
  }
});

</script>
