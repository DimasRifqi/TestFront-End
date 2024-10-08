import React from "react";
import { Link } from "@inertiajs/inertia-react";
import { usePage } from "@inertiajs/inertia-react";
import { Inertia } from "@inertiajs/inertia";

export default function Index({ mahasiswa }) {
    const { flash } = usePage().props;

    const deleteData = (id,nama) => {
        if(confirm(`Yakin menghapus data mahasiswa dengan nama ${nama} dihapus ?`)){
            Inertia.delete(`/mahasiswa/${id}`);
        }
    }

    const editData = (id) => {
        Inertia.get(`/mahasiswa/${id}`);
    }


    return (
        <div>
            <h3>Data Mahasiswa</h3>
            <hr />

            <Link
                as="button"
                type="button"
                href="/mahasiswa/add"
                style={{ color: "black", marginBottom: 10 }}
            >
                Tambah Data
            </Link>

            {flash && flash.message && <div style={{
                fontWeight: 'bolde',
                color: 'green',
                marginBottom: 10
             }}>{flash.message}</div>}

            <table
                cellPadding={5}
                border={1}
                style={{
                    borderCollapse: "collapse",
                }}
            >
                <thead>
                    <tr>
                        <th>No</th>
                        <th>NPM</th>
                        <th>Nama Lengkap</th>
                        <th>Jenis Kelamin</th>
                        <th>Alamat</th>
                    </tr>
                </thead>

                <tbody>
                    {mahasiswa.length === 0 ? (
                        <tr>
                            <th colspan={5}>Data Kosong...</th>
                        </tr>
                    ) : (
                        mahasiswa.map((mhs, index) => (
                            <tr key={index}>
                                <td>{index + 1}</td>
                                <td>{mhs.npm}</td>
                                <td>{mhs.nama_lengkap}</td>
                                <td>
                                    {mhs.jk == "L" ? "laki-laki" : "Perempuan"}
                                </td>
                                <td>{mhs.alamat}</td>
                                <td>
                                    <button
                                     onClick={() => editData(mhs.id)}

                                    >Edit</button>

                                    <button style={{marginLeft:5}}
                                        onClick={() => deleteData(mhs.id, mhs.nama_lengkap)}
                                    >Hapus</button>
                                </td>
                            </tr>
                        ))
                    )}
                </tbody>
            </table>
        </div>
    );
}
