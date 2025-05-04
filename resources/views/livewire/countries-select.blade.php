<div class="form-row">
    <div class="form-group col-lg-12">
        <div class="custom_select">
            <select class="form-control select-active" name="country" id="country">
                <option value="">Choose a option...</option>
                <option value="AC" {{$billingDetails && $billingDetails->country == 'AC' ? 'selected' : ''}}>Aceh</option>
                <option value="BA" {{$billingDetails && $billingDetails->country == 'BA' ? 'selected' : ''}}>Bali</option>
                <option value="BT" {{$billingDetails && $billingDetails->country == 'BT' ? 'selected' : ''}}>Banten</option>
                <option value="BE" {{$billingDetails && $billingDetails->country == 'BE' ? 'selected' : ''}}>Bengkulu</option>
                <option value="DIY" {{$billingDetails && $billingDetails->country == 'DIY' ? 'selected' : ''}}>Daerah Istimewa Yogyakarta</option>
                <option value="DKJ" {{$billingDetails && $billingDetails->country == 'DKJ' ? 'selected' : ''}}>Daerah Khusus Jakarta</option>
                <option value="JA" {{$billingDetails && $billingDetails->country == 'JA' ? 'selected' : ''}}>Jambi</option>
                <option value="JB" {{$billingDetails && $billingDetails->country == 'JB' ? 'selected' : ''}}>Jawa Barat</option>
                <option value="JT" {{$billingDetails && $billingDetails->country == 'JT' ? 'selected' : ''}}>Jawa Timur</option>
                <option value="JE" {{$billingDetails && $billingDetails->country == 'JE' ? 'selected' : ''}}>Jawa Tengah</option>
                <option value="KB" {{$billingDetails && $billingDetails->country == 'KB' ? 'selected' : ''}}>Kalimantan Barat</option>
                <option value="KS" {{$billingDetails && $billingDetails->country == 'KS' ? 'selected' : ''}}>Kalimantan Selatan</option>
                <option value="KT" {{$billingDetails && $billingDetails->country == 'KT' ? 'selected' : ''}}>Kalimantan Tengah</option>
                <option value="KE" {{$billingDetails && $billingDetails->country == 'KE' ? 'selected' : ''}}>Kalimantan Timur</option>
                <option value="KU" {{$billingDetails && $billingDetails->country == 'KU' ? 'selected' : ''}}>Kalimantan Utara</option>
                <option value="BB" {{$billingDetails && $billingDetails->country == 'BB' ? 'selected' : ''}}>Kepulauan Bangka Belitung</option>
                <option value="KR" {{$billingDetails && $billingDetails->country == 'KR' ? 'selected' : ''}}>Kepulauan Riau</option>
                <option value="LA" {{$billingDetails && $billingDetails->country == 'LA' ? 'selected' : ''}}>Lampung</option>
                <option value="MU" {{$billingDetails && $billingDetails->country == 'MU' ? 'selected' : ''}}>Maluku</option>
                <option value="MN" {{$billingDetails && $billingDetails->country == 'MN' ? 'selected' : ''}}>Maluku Utara</option>
                <option value="NTB" {{$billingDetails && $billingDetails->country == 'NTB' ? 'selected' : ''}}>Nusa Tenggara Barat</option>
                <option value="NTT" {{$billingDetails && $billingDetails->country == 'NTT' ? 'selected' : ''}}>Nusa Tenggara Timur</option>
                <option value="PA" {{$billingDetails && $billingDetails->country == 'PA' ? 'selected' : ''}}>Papua</option>
                <option value="PB" {{$billingDetails && $billingDetails->country == 'PB' ? 'selected' : ''}}>Papua Barat</option>
                <option value="PBD" {{$billingDetails && $billingDetails->country == 'PBD' ? 'selected' : ''}}>Papua Barat Daya</option>
                <option value="PP" {{$billingDetails && $billingDetails->country == 'PP' ? 'selected' : ''}}>Papua Pegunungan</option>
                <option value="PS" {{$billingDetails && $billingDetails->country == 'PS' ? 'selected' : ''}}>Papua Selatan</option>
                <option value="PT" {{$billingDetails && $billingDetails->country == 'PT' ? 'selected' : ''}}>Papua Tengah</option>
                <option value="RI" {{$billingDetails && $billingDetails->country == 'RI' ? 'selected' : ''}}>Riau</option>
                <option value="SBT" {{$billingDetails && $billingDetails->country == 'SBT' ? 'selected' : ''}}>Sulawesi Barat</option>
                <option value="SG" {{$billingDetails && $billingDetails->country == 'SG' ? 'selected' : ''}}>Sulawesi Selatan</option>
                <option value="SGE" {{$billingDetails && $billingDetails->country == 'SGE' ? 'selected' : ''}}>Sulawesi Tengah</option>
                <option value="ST" {{$billingDetails && $billingDetails->country == 'ST' ? 'selected' : ''}}>Sulawesi Tenggara</option>
                <option value="SL" {{$billingDetails && $billingDetails->country == 'SL' ? 'selected' : ''}}>Sulawesi Utara</option>
                <option value="SB" {{$billingDetails && $billingDetails->country == 'SB' ? 'selected' : ''}}>Sumatra Barat</option>
                <option value="SS" {{$billingDetails && $billingDetails->country == 'SS' ? 'selected' : ''}}>Sumatra Selatan</option>
                <option value="SU" {{$billingDetails && $billingDetails->country == 'SU' ? 'selected' : ''}}>Sumatra Utara</option>
            </select>
        </div>
    </div>
</div>

