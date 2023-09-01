<!DOCTYPE html>
<html lang="en">
<head>
    <title>Hasil Lab {{$pasien->nm_pasien}} {{$periksalab->nm_perawatan}}</title>
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
        .tb-detail{
            border: 1px solid black;
            border-collapse: collapse;
        }
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
    </style>
</head>
<body>
    <table style="width:100%">
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
            <td colspan="6" class="text-center pb-20 font-big"><strong>Hasil Pemeriksaan Laboratorium</strong></td>
        </tr>
        <tr style="font-size: 14px">
            <td>No RM</td>
            <td class="w-2">:</td>
            <td>{{$pasien->no_rkm_medis}}</td>
            <td class="pl-15">Penanggung Jawab</td>
            <td class="w-2">:</td>
            <td>{{$pasien->dokter_pj}}</td>
        </tr>
        <tr style="font-size: 14px">
            <td>Nama Pasien</td>
            <td class="w-2">:</td>
            <td>{{$pasien->nm_pasien}}</td>
            <td class="pl-15">Dokter Pengirim</td>
            <td class="w-2">:</td>
            <td>{{$pasien->nm_dokter}}</td>
        </tr>
        <tr style="font-size: 14px">
            <td>JK/Umur</td>
            <td class="w-2">:</td>
            <td>{{$pasien->jk}} / {{$pasien->umur}}</td>
            <td class="pl-15">Tgl.Pemeriksaan</td>
            <td class="w-2">:</td>
            <td>{{$pasien->tgl_periksa}}</td>
        </tr>
        <tr style="font-size: 14px">
            <td>Alamat</td>
            <td class="w-2">:</td>
            <td>{{$pasien->alamat}}, {{$pasien->nm_kel}}, {{$pasien->nm_kec}}, {{$pasien->nm_kab}}</td>
            <td class="pl-15">Jam Pemeriksaan</td>
            <td class="w-2">:</td>
            <td>{{$pasien->jam}}</td>
        </tr>
        <tr style="font-size: 14px">
            <td>No.Periksa</td>
            <td class="w-2">:</td>
            <td>{{$pasien->no_rawat}}</td>
            <td class="pl-15">Poli</td>
            <td class="w-2">:</td>
            <td>{{$pasien->nm_poli}}</td>
        </tr>
        <tr style="font-size: 14px" >
            <td class="pt-20 pb-20">Pemeriksaan</td>
            <td class="w-2 pt-20 pb-20">:</td>
            <td class="pt-20 pb-20" colspan="4"><strong>{{$periksalab->nm_perawatan}}</strong></td>
           
        </tr>
    </table>

    <table style="width: 100%" class="tb-detail">
        <tr class="tb-detail">
            <th  class="tb-detail">Detail Pemeriksaan</th>
            <th  class="tb-detail">Hasil</th>
            <th  class="tb-detail">Satuan</th>
            <th class="tb-detail">Nilai Rujukan</th>
            <th class="tb-detail">Keterangan</th>
        </tr>
        
        @foreach ($detail_periksa_lab as $item)
        <tr class="tb-detail ">
            <td class="tb-detail">{{$item->Pemeriksaan}}</td>
            <td class="tb-detail text-center">{{$item->nilai}}</td>
            <td class="tb-detail text-center">{{$item->satuan}}</td>
            <td class="tb-detail text-center">{{$item->nilai_rujukan}}</td>
            <td class="tb-detail text-center">{{$item->keterangan}}</td>
        </tr>
        @endforeach
        
    </table>

    <table style="width: 100%; margin-top: 20px;">
        <tr class="text-center">
            <td>Penanggung Jawab</td>
            <td>Petugas Laboratorium</td>
        </tr>
        <tr class="text-center" >
            <td style="padding-top: 60px;">{{$pasien->dokter_pj}}</td>
            <td style="padding-top: 60px;">{{$pasien->nama}}</td>
        </tr>
    </table>

    
</body>
</html>