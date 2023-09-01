<!DOCTYPE html>
<html lang="en">
<head>
    <title>Hasil MCU {{$periksa_mcu->nm_pasien}}-{{$periksa_mcu->no_rawat}}</title>

    <style>
         /* table {
            border: 1px solid black;
            border-collapse: collapse;
        }
        td{
            border: 1px solid black;
            border-collapse: collapse;
        }
        th{
            border: 1px solid black;
            border-collapse: collapse;
        } */
        /* .tb-detail{
            border: 1px solid black;
            border-collapse: collapse;
        } */
        .text-center{
            text-align: center;
        }
        .title{
            font-size: 20px;
            text-transform: uppercase;
        }
        .font-big{
            text-transform: uppercase;
        }
        .sub-title{
            font-size: 12px;
        }
        .w-2{
            width: 2%;
        }
        .pb-20{
            padding-bottom: 20px;
        }
        .pl-15{
            padding-left: 15px;
        }
        .pt-20{
            padding-top: 20px;
        }
        .font-10{
            font-size: 13px;
        }
        .text-top{
            vertical-align: top;
        }
        .text-right{
            text-align: right;
        }
    </style>
</head>
<body>
    <table style="width: 100%">
        <tr>
            {{-- <td  style="width: 50%"><img src="{{public_path('Setting/Logo/LOGO ASLI_1688342614.jpg')}}" width="20%" style="margin: 0px"> </td> --}}
            <td colspan="6" class="text-center title"><strong>{{$aplikasi->nama_instansi}}</strong></td>
        </tr>
        <tr>
            {{-- <td colspan="6" class="text-center sub-title">{{$aplikasi->alamat}}</td> --}}
        </tr>
        <tr>
            {{-- <td colspan="6" class="text-center sub-title">{{$aplikasi->no_telp}}</td> --}}
        </tr>
        <tr>
            {{-- <td colspan="6" class="text-center sub-title">{{$aplikasi->email}}</td> --}}
        </tr>
        <tr>
            <td colspan="6" class="text-center sub-title"></td>
        </tr>
        <tr>
            <td colspan="6" class="text-center sub-title"><hr></td>
        </tr>
        <tr>
            <td colspan="6" class="text-center pb-20 font-big"><strong>Hasil Medical Check Up</strong></td>
        </tr>
        <tr>
            <td colspan="6" class="text-center font-big">Nomor : {{$periksa_mcu->no_rawat}}</td>
        </tr>
        <tr class="font-10">
            <td>No RM</td>
            <td class="w-2">:</td>
            <td> {{$periksa_mcu->no_rkm_medis}}</td>
            <td class="pl-15">Jenis Kelamin</td>
            <td class="w-2">:</td>
            <td> {{$periksa_mcu->jk}}</td>
           
        </tr>
        <tr  class="font-10">
            <td>Nama Pasien</td>
            <td class="w-2">:</td>
            <td>{{$periksa_mcu->nm_pasien}}</td>
            <td class="pl-15">Tgl Lahir</td>
            <td class="w-2">:</td>
            <td> {{$periksa_mcu->tgl_lahir}}</td>
            
        </tr>
        <tr  class="font-10">
            <td>Alamat</td>
            <td class="w-2">:</td>
            <td> {{$periksa_mcu->alamat}}</td>
            <td class="pl-15">Status Nikah</td>
            <td class="w-2">:</td>
            <td >{{$periksa_mcu->stts_nikah}}</td>
        </tr>
        <tr  class="font-10">
            <td>Tanggal</td>
            <td class="w-2">:</td>
            <td> {{$periksa_mcu->tanggal}}</td>
            <td class="pl-15">Informasi</td>
            <td class="w-2">:</td>
            <td> {{$periksa_mcu->informasi}}</td>
        </tr>
    </table>

    <table class="pt-20 tb-detail" style="width: 100%">
        <tr class="tb-detail">
            <td colspan="6"><strong>A. ANAMNESA SINGKAT</strong> </td>
        </tr>
        <tr class="font-10 tb-detail">
            <td class="tb-detail text-top">Riwayat Penyakit Sekarang</td>
            <td class="w-2 tb-detail text-top">:</td>
            <td class="tb-detail text-top" height="90px">{{$periksa_mcu->rps}}</td>
            <td class="tb-detail text-top">Riwayat Penyakit Keluarga</td>
            <td class="w-2 tb-detail text-top">:</td>
            <td class="tb-detail text-top" > {{$periksa_mcu->rpk}}</td>
        </tr>
        <tr class="font-10 tb-detail">
            <td class="tb-detail text-top">Riwayat Penyakit Dahulu</td>
            <td class="w-2 tb-detail text-top">:</td>
            <td class="tb-detail text-top" height="90px">{{$periksa_mcu->rpd}}</td>
            <td class="tb-detail text-top">Riwayat Alergi Makanan & Obat</td>
            <td class="w-2 tb-detail text-top">:</td>
            <td class="tb-detail text-top"> {{$periksa_mcu->alergi}}</td>
        </tr>
        <tr class="tb-detail">
            <td colspan="6"> <strong>B. PEMERIKSAAN FISIK</strong></td>
        </tr>
        <tr class="font-10 tb-detail">
            <td class="tb-detail">Keadaan Umum</td>
            <td class="w-2 tb-detail">:</td>
            <td class="tb-detail"> {{$periksa_mcu->keadaan}}</td>
            <td class="tb-detail">Kesadaran</td>
            <td class="w-2 tb-detail">:</td>
            <td class="tb-detail"> {{$periksa_mcu->kesadaran}}</td>
        </tr>
        <tr class="font-10 tb-detail">
            <td class="tb-detail">TD</td>
            <td class="w-2 tb-detail">:</td>
            <td class="tb-detail"> {{$periksa_mcu->td}} mmHg</td>
            <td class="tb-detail">HR</td>
            <td class="w-2 tb-detail">:</td>
            <td class="tb-detail"> {{$periksa_mcu->nadi}} x/menit</td>
        </tr>
        <tr class="font-10 tb-detail">
            <td class="tb-detail">RR</td>
            <td class="w-2 tb-detail">:</td>
            <td class="tb-detail"> {{$periksa_mcu->rr}} x/menit</td>
            <td class="tb-detail">Suhu</td>
            <td class="w-2 tb-detail">:</td>
            <td class="tb-detail"> {{$periksa_mcu->suhu}} C</td>
        </tr>
        <tr class="font-10 tb-detail">
            <td class="tb-detail">Tinggi Badan</td>
            <td class="w-2 tb-detail">:</td>
            <td class="tb-detail">{{$periksa_mcu->tb}} cm</td>
            <td class="tb-detail">Berat badan</td>
            <td class="w-2 tb-detail">:</td>
            <td class="tb-detail"> {{$periksa_mcu->bb}} Kg</td>
        </tr>
        <tr class="font-10 tb-detail">
            <td colspan="6"><strong>Kelenjar Limfe :</strong></td>
        </tr>
        <tr class="font-10 tb-detail">
            <td class="tb-detail pl-15">Submandibula</td>
            <td class="w-2 tb-detail">:</td>
            <td class="tb-detail">{{$periksa_mcu->submandibula}}</td>
            <td class="tb-detail">Axilla</td>
            <td class="w-2 tb-detail">:</td>
            <td class="tb-detail">{{$periksa_mcu->axilla}}</td>
        </tr>
        <tr class="font-10 tb-detail">
            <td class="tb-detail pl-15">Supraklavikula</td>
            <td class="w-2 tb-detail">:</td>
            <td class="tb-detail">{{$periksa_mcu->supraklavikula}}</td>
            <td class="tb-detail">Leher</td>
            <td class="w-2 tb-detail">:</td>
            <td class="tb-detail">{{$periksa_mcu->leher}}</td>
        </tr>
        <tr class="font-10 tb-detail">
            <td class="tb-detail pl-15">Inguinal</td>
            <td class="w-2 tb-detail">:</td>
            <td class="tb-detail" colspan="4">{{$periksa_mcu->inguinal}}</td>
        </tr>
        <tr class="font-10 tb-detail">
            <td colspan="6"><strong>Kepala :</strong></td>
        </tr>
        <tr class="font-10 tb-detail">
            <td colspan="6">1. Muka</td>
        </tr>
        <tr class="font-10 tb-detail">
            <td class="tb-detail pl-15">Oedema</td>
            <td class="w-2 tb-detail">:</td>
            <td class="tb-detail">{{$periksa_mcu->oedema}}</td>
            <td class="tb-detail">Nyeri Tekanan Sinus Frontalis</td>
            <td class="w-2 tb-detail">:</td>
            <td class="tb-detail">{{$periksa_mcu->sinus_frontalis}}</td>
        </tr>
        <tr class="font-10 tb-detail">
            <td class="tb-detail pl-15">Nyeri Tekanan Sinus Maxilaris</td>
            <td class="w-2 tb-detail">:</td>
            <td class="tb-detail" colspan="4">{{$periksa_mcu->sinus_maxilaris}}</td>
        </tr>
        <tr class="font-10 tb-detail">
            <td colspan="6">2. Mata</td>
        </tr>
        <tr class="font-10 tb-detail">
            <td class="tb-detail pl-15">Palpebra</td>
            <td class="w-2 tb-detail">:</td>
            <td class="tb-detail">{{$periksa_mcu->palpebra}}</td>
            <td class="tb-detail">Sklera</td>
            <td class="w-2 tb-detail">:</td>
            <td class="tb-detail">{{$periksa_mcu->sklera}}</td>
        </tr>
        <tr class="font-10 tb-detail">
            <td class="tb-detail pl-15">Cornea</td>
            <td class="w-2 tb-detail">:</td>
            <td class="tb-detail">{{$periksa_mcu->cornea}}</td>
            <td class="tb-detail">Buta Warna</td>
            <td class="w-2 tb-detail">:</td>
            <td class="tb-detail">{{$periksa_mcu->buta_warna}}</td>
        </tr>
        <tr class="font-10 tb-detail">
            <td class="tb-detail pl-15">Konjungtiva</td>
            <td class="w-2 tb-detail">:</td>
            <td class="tb-detail">{{$periksa_mcu->konjungtiva}}</td>
            <td class="tb-detail">Lensa</td>
            <td class="w-2 tb-detail">:</td>
            <td class="tb-detail">{{$periksa_mcu->lensa}}</td>
        </tr>
        <tr class="font-10 tb-detail">
            <td class="tb-detail pl-15">Pupil</td>
            <td class="w-2 tb-detail">:</td>
            <td class="tb-detail" colspan="4">{{$periksa_mcu->pupil}}</td>
        </tr>
        <tr class="font-10 tb-detail">
            <td colspan="6">3. Telinga</td>
        </tr>
        <tr class="font-10 tb-detail">
            <td class="tb-detail pl-15">Lubang</td>
            <td class="w-2 tb-detail">:</td>
            <td class="tb-detail">{{$periksa_mcu->lubang_telinga}}</td>
            <td class="tb-detail">Daun</td>
            <td class="w-2 tb-detail">:</td>
            <td class="tb-detail">{{$periksa_mcu->daun_telinga}}</td>
        </tr>
        <tr class="font-10 tb-detail">
            <td class="tb-detail pl-15">Proc. Mastoideus</td>
            <td class="w-2 tb-detail">:</td>
            <td class="tb-detail">{{$periksa_mcu->proc_mastoideus}}</td>
            <td class="tb-detail">Selaput Pendengaran</td>
            <td class="w-2 tb-detail">:</td>
            <td class="tb-detail">{{$periksa_mcu->selaput_pendengaran}}</td>
        </tr>
        <tr class="font-10 tb-detail">
            <td colspan="6">4. Mulut</td>
        </tr>
        <tr class="font-10 tb-detail">
            <td class="tb-detail pl-15">Bibir</td>
            <td class="w-2 tb-detail">:</td>
            <td class="tb-detail">{{$periksa_mcu->bibir}}</td>
            <td class="tb-detail">Caries</td>
            <td class="w-2 tb-detail">:</td>
            <td class="tb-detail">{{$periksa_mcu->caries}}</td>
        </tr>
        <tr class="font-10 tb-detail">
            <td class="tb-detail pl-15">Lidah</td>
            <td class="w-2 tb-detail">:</td>
            <td class="tb-detail">{{$periksa_mcu->lidah}}</td>
            <td class="tb-detail">Faring</td>
            <td class="w-2 tb-detail">:</td>
            <td class="tb-detail">{{$periksa_mcu->faring}}</td>
        </tr>
        <tr class="font-10 tb-detail">
            <td class="tb-detail pl-15">Tonsil</td>
            <td class="w-2 tb-detail">:</td>
            <td class="tb-detail" colspan="4">{{$periksa_mcu->tonsil}}</td>
        </tr>
        <tr class="font-10 tb-detail">
            <td colspan="6">5. Leher</td>
        </tr>
        <tr class="font-10 tb-detail">
            <td class="tb-detail pl-15">Kelenjar Limfe</td>
            <td class="w-2 tb-detail">:</td>
            <td class="tb-detail">{{$periksa_mcu->kelenjar_limfe}}</td>
            <td class="tb-detail">Kelenjar Gondok</td>
            <td class="w-2 tb-detail">:</td>
            <td class="tb-detail">{{$periksa_mcu->kelenjar_gondok}}</td>
        </tr>
        <tr class="font-10 tb-detail">
            <td colspan="6"><strong>Dada :</strong></td>
        </tr>
        <tr class="font-10 tb-detail">
            <td colspan="6">1. Paru</td>
        </tr>
        <tr class="font-10 tb-detail">
            <td class="tb-detail pl-15">Gerakan</td>
            <td class="w-2 tb-detail">:</td>
            <td class="tb-detail">{{$periksa_mcu->gerakan_dada}}</td>
            <td class="tb-detail">Vocal Fremitus</td>
            <td class="w-2 tb-detail">:</td>
            <td class="tb-detail">{{$periksa_mcu->vocal_femitus}}</td>
        </tr>
        <tr class="font-10 tb-detail">
            <td class="tb-detail pl-15">Perkusi</td>
            <td class="w-2 tb-detail">:</td>
            <td class="tb-detail">{{$periksa_mcu->perkusi_dada}}</td>
            <td class="tb-detail">Bunyi Napas</td>
            <td class="w-2 tb-detail">:</td>
            <td class="tb-detail">{{$periksa_mcu->bunyi_napas}}</td>
        </tr>
        <tr class="font-10 tb-detail">
            <td class="tb-detail pl-15">Bunyi</td>
            <td class="w-2 tb-detail">:</td>
            <td class="tb-detail" colspan="4">{{$periksa_mcu->bunyi_tambahan}}</td>
        </tr>
        <tr class="font-10 tb-detail">
            <td colspan="6">2. Jantung</td>
        </tr>
        <tr class="font-10 tb-detail">
            <td class="tb-detail pl-15">Ictus Cordis</td>
            <td class="w-2 tb-detail">:</td>
            <td class="tb-detail">{{$periksa_mcu->ictus_cordis}}</td>
            <td class="tb-detail">Bunyi Jantung</td>
            <td class="w-2 tb-detail">:</td>
            <td class="tb-detail">{{$periksa_mcu->bunyi_jantung}}</td>
        </tr>
        <tr class="font-10 tb-detail">
            <td class="tb-detail pl-15">Batas</td>
            <td class="w-2 tb-detail">:</td>
            <td class="tb-detail" colspan="4">{{$periksa_mcu->batas}}</td>
        </tr>
        <tr class="font-10 tb-detail">
            <td colspan="6"><strong>Abdomen :</strong></td>
        </tr>
        <tr class="font-10 tb-detail">
            <td class="tb-detail pl-15">Inspeksi</td>
            <td class="w-2 tb-detail">:</td>
            <td class="tb-detail">{{$periksa_mcu->inspeksi}}</td>
            <td class="tb-detail">Palpasi</td>
            <td class="w-2 tb-detail">:</td>
            <td class="tb-detail">{{$periksa_mcu->palpasi}}</td>
        </tr>
        <tr class="font-10 tb-detail">
            <td class="tb-detail pl-15">Perkusi</td>
            <td class="w-2 tb-detail">:</td>
            <td class="tb-detail">{{$periksa_mcu->perkusi_abdomen}}</td>
            <td class="tb-detail">Auskultasi</td>
            <td class="w-2 tb-detail">:</td>
            <td class="tb-detail">{{$periksa_mcu->auskultasi}}</td>
        </tr>
        <tr class="font-10 tb-detail">
            <td class="tb-detail pl-15">Hepar</td>
            <td class="w-2 tb-detail">:</td>
            <td class="tb-detail">{{$periksa_mcu->hepar}}</td>
            <td class="tb-detail">Limpa</td>
            <td class="w-2 tb-detail">:</td>
            <td class="tb-detail">{{$periksa_mcu->limpa}}</td>
        </tr>
        <tr class="font-10 tb-detail">
            <td colspan="3" class="pt-20"><strong>Punggung :</strong></td>
            <td colspan="3" class="pt-20"><strong>Kulit :</strong></td>
        </tr>
        <tr class="font-10 tb-detail">
            <td class="tb-detail pl-15">Nyeri Ketok Costovertebral Angle/CVA</td>
            <td class="w-2 tb-detail">:</td>
            <td class="tb-detail">{{$periksa_mcu->costovertebral}}</td>
            <td class="tb-detail pl-15">Kondisi Kulit</td>
            <td class="w-2 tb-detail">:</td>
            <td class="tb-detail">{{$periksa_mcu->kondisi_kulit}}</td>
        </tr>
        <tr class="font-10 tb-detail">
            <td colspan="6" class="pt-20"><strong>Anggota Gerak :</strong></td>
        </tr>
        <tr class="font-10 tb-detail">
            <td class="tb-detail pl-15">Extermitas Atas</td>
            <td class="w-2 tb-detail">:</td>
            <td class="tb-detail">{{$periksa_mcu->ekstrimitas_atas}} {{$periksa_mcu->ekstrimitas_atas_ket}}</td>
            <td class="tb-detail">Extermitas Bawah</td>
            <td class="w-2 tb-detail">:</td>
            <td class="tb-detail">{{$periksa_mcu->ekstrimitas_bawah}}  {{$periksa_mcu->ekstrimitas_bawah_ket}}</td>
        </tr>
        <tr class="tb-detail" >
            <td colspan="6"><strong>C. RONGSEN THORAX</strong></td>
        </tr>
        <tr class="tb-detail font-10" >
            <td colspan="6" class="pl-15 text-top" height="80px">{{$periksa_mcu->radiologi}}</td>
        </tr>
        <tr class="tb-detail" >
            <td colspan="6"><strong>D. EKG</strong></td>
        </tr>
        <tr class="tb-detail font-10" >
             <td colspan="6" class="pl-15 text-top" height="80px">{{$periksa_mcu->ekg}}</td>
        </tr>
        <tr class="tb-detail" >
            <td colspan="6"><strong>E. SPIROMETRI</strong></td>
        </tr>
        <tr class="tb-detail font-10" >
             <td colspan="6" class="pl-15 text-top" height="80px">{{$periksa_mcu->spirometri}}</td>
        </tr>
        <tr class="tb-detail" >
            <td colspan="6"><strong>F. AUDIOMETRI</strong></td>
        </tr>
        <tr class="tb-detail font-10" >
             <td colspan="6" class="pl-15 text-top" height="80px">{{$periksa_mcu->audiometri}}</td>
        </tr>
        <tr class="tb-detail" >
            <td colspan="6"><strong>G. TREADMILL</strong></td>
        </tr>
        <tr class="tb-detail font-10" >
             <td colspan="6" class="pl-15 text-top" height="80px">{{$periksa_mcu->treadmill}}</td>
        </tr>
        {{-- <tr class="tb-detail" >
            <td colspan="6">H. LAIN-LAIN</td>
        </tr>
        <tr class="tb-detail" >
             <td colspan="6" class="pl-15 text-top" height="80px">{{$periksa_mcu->radiologi}}</td>
        </tr> --}}
        <tr class="tb-detail" >
            <td colspan="6"><strong>I. RIWAYAT MEROKOK DAN KONSUMSI ALKOHOL</strong></td>
        </tr>
        <tr class="font-10 tb-detail" >
            <td class="tb-detail pl-15 text-top">Merokok</td>
            <td class="w-2 tb-detail text-top">:</td>
            <td class="tb-detail text-top" colspan="4"  height="50px">{{$periksa_mcu->merokok}}</td>
        </tr>
        <tr class="font-10 tb-detail" >
            <td class="tb-detail pl-15 text-top">Alkohol</td>
            <td class="w-2 tb-detail text-top">:</td>
            <td class="tb-detail text-top" colspan="4"  height="50px">{{$periksa_mcu->alkohol}}</td>
        </tr>
        <tr class="tb-detail" >
            <td colspan="6"><strong>J. KESIMPULAN</strong></td>
        </tr>
        <tr class="tb-detail font-10" >
            <td colspan="6" class="pl-15 text-top" height="50px">{{$periksa_mcu->kesimpulan}}</td>
        </tr>
        <tr class="tb-detail " >
            <td colspan="6"><strong>K. ANJURAN</strong></td>
        </tr>
        <tr class="tb-detail font-10" >
             <td colspan="6" class="pl-15 text-top" height="50px">{{$periksa_mcu->anjuran}}</td>
        </tr>
        <tr>
            <td class="text-right" colspan="6">Dokter Penanggung Jawab</td>
        </tr>
        <tr>
            <td class="text-right" colspan="6" height="90px"></td>
        </tr>
        <tr>
            <td class="text-right" colspan="6">{{$periksa_mcu->nm_dokter}}</td>
        </tr>
    </table>
    
</body>
</html>