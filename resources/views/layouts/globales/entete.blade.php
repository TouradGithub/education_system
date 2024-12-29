<br>
<div style="width:100%">
    @php
        $entete = Dcs\Core\stabs\App\Models\Entete::find(1);
        $titre1 = $entete->titre1;
        $titre2 = $entete->titre2;
        $titre3 = $entete->titre3;
        $titre1_ar = $entete->titre1_ar;
        $titre2_ar = $entete->titre2_ar;
        $titre3_ar = $entete->titre3_ar;
    @endphp
    <table width="100%">
        <tr>
            <td class="t_left">
                <table>
                    @if($entete->afficher_titre1)
                        <tr>
                            <td class="titre">{{ $titre1 }}</td>
                        </tr>
                    @endif
                    @if($entete->afficher_titre2)
                        <tr>
                            <td class="titre">{{ $titre2 }}</td>
                        </tr>
                    @endif
                    @if($entete->afficher_titre3)
                        <tr>
                            <td class="titre3">{{ $titre3 }}</td>
                        </tr>
                    @endif
                </table>
            </td>
            <td class="t_center">
                <table>
                    <tr>
                        <td align="center">
                            <img style="width: 100px; height: 100px;" src="{{ asset($entete->logo) }}" alt="avatar"/>
                        </td>
                    </tr>
                </table>
            </td>
            <td class="t_right">
                <table>
                    @if($entete->afficher_titre1)
                        <tr>
                            <td class="titre_ar">{{ $titre1_ar }}</td>
                        </tr>
                    @endif
                    @if($entete->afficher_titre2)
                        <tr>
                            <td class="titre_ar">{{ $titre2_ar }}</td>
                        </tr>
                    @endif
                    @if($entete->afficher_titre3)
                        <tr>
                            <td class="titre3_ar">{{ $titre3_ar }}</td>
                        </tr>
                    @endif
                </table>
            </td>
        </tr>
    </table>
</div>
<hr>

<style>
    .t_right {
        text-align: right !important;
    }
</style>
