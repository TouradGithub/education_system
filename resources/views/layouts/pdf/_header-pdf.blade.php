<style>

    #header {
        direction: rtl !important;
    }

    .actLeftContentCommune {
        margin: -50px auto 25px;
        font-size: 8px;
        text-align: center;
    }

    .header-text-left,
    .header-text-left_ar{
        color: #000;
        direction: rtl;
        text-transform: uppercase;
    }

    .header-text-left {
        font-size: 8px;
        font-family: louguiyaFR;
    }

    .header-text-left_ar {
        font-size: 10px;
        font-family: 'fontarab', sans-serif !important;
    }

    .header-text-number-ar,
    .header-text-number {
        direction: rtl;
        color: #000;
        line-height: .8;
    }

    .header-text-number {
        font-size: 10px;
    }

    .header-text-number-ar {
        font-size: 12px;
        font-family: fontarab, 'sans-serif';
    }
</style>
<div id="header">
    <img src="media/img/header.png" alt=""/>
</div>
<div class="actLeftContentCommune">
    <table style=" width: 80%;">
        <tr>
            <td style="text-align: center; line-height: 1.8">
                <div>
                    <p class="header-text-left_ar"> وزارة الدّاخليّة و اللّامركزيّة</p>
                    <p class="header-text-left">MINISTERE DE L'ENTERIEUR ET DE LA DECENTRALISATION</p>
                </div>
                <div>
                    <p class="header-text-left_ar" style="font-family: 'louguiya',sans-serif">
                        ولاية {{ $wilaya_ar }} </p>
                    <p class="header-text-left">WILAYA DE {{ $wilaya }}</p>
                </div>
                <div>
                    <p class="header-text-left_ar">مقاطعة {{ $moughataa_ar }} </p>
                    <p class="header-text-left">MAOUGHATAA DE {{$moughataa}}</p>
                </div>
                <div>
                    <p class="header-text-left_ar"> بلديّة {{$commune_ar}}</p>
                    <p class="header-text-left">COMMUNE DE {{$commune}}</p>
                </div>
            </td>
            <td style="text-align: right;vertical-align:bottom;
             line-height: 1.4; padding-bottom: 10px">
                <div style="line-height: 0.8">
                    <p><span class="header-text-number">{{" le "}} {{" 12/12/02 "}}</span><span
                            class="header-text-number-ar">{{" في"}}</span></p>
                </div>
            </td>
        </tr>
    </table>
    <div style="
    background-color: #90bd9d; padding: 10px;
    color: #000;
    font-size: 14px;
    text-align: center;
    margin: 10px 120px 0 0;
    border-top-right-radius: 50%;
    border-bottom-right-radius: 50%;">
      <span>
          @if(App::getLocale() == 'ar')
              <span>{{$title_ar}} </span>
          @else
              <span>{{$title}}</span>
          @endif
      </span>
    </div>
</div>
