import java.util.ArrayList;
import java.util.Scanner;

// Class utama untuk menjalankan program
public class Main
{
    // Menyimpan kumpulan object Film
    static ArrayList<Film> daftarFilm = new ArrayList<>();
    static Scanner input = new Scanner(System.in);

    // Mencari index film berdasarkan ID
    static int cariIndex(String id)
    {
        for (int i = 0; i < daftarFilm.size(); i++)
        {
            if (daftarFilm.get(i).getIdFilm().equals(id))
            {
                return i;
            }
        }

        return -1;
    }

    // Mengecek apakah ID sudah digunakan
    static boolean isIdExists(String id)
    {
        return cariIndex(id) != -1;
    }

    // Input durasi dengan error handling
    static int inputDurasi()
    {
        while (true)
        {
            try
            {
                System.out.print("Durasi: ");
                int durasi = input.nextInt();
                input.nextLine();

                if (durasi < 0)
                {
                    System.out.println("Durasi tidak boleh negatif!");
                }
                else
                {
                    return durasi;
                }
            }
            catch (Exception e)
            {
                System.out.println("Durasi harus berupa angka!");
                input.nextLine();
            }
        }
    }

    // Menampilkan pilihan menu utama
    static void tampilkanMenu()
    {
        System.out.println("\n<================ Menu Bioskop ================>");
        System.out.println("1. Tambah Data Film");
        System.out.println("2. Tampilkan Semua Data Film");
        System.out.println("3. Update Data Film");
        System.out.println("4. Hapus Data Film");
        System.out.println("5. Cari Data Film");
        System.out.println("6. Keluar");
        System.out.print("Masukkan pilihan: ");
    }

    // Menambahkan data film baru
    static void tambahData()
    {
        System.out.println("\n--- Tambahkan Data Film ---");

        String id;

        // Memastikan ID film tidak sama
        do
        {
            System.out.print("\nID Film: ");
            id = input.nextLine();

            if (isIdExists(id))
            {
                System.out.println(
                    "ID ini sudah ada. Silakan masukkan ID lain."
                );
            }

        } while (isIdExists(id));

        System.out.print("\nJudul: ");
        String judul = input.nextLine();

        System.out.print("\nGenre: ");
        String genre = input.nextLine();

        int durasi = inputDurasi();

        System.out.print("\nSutradara: ");
        String sutradara = input.nextLine();

        // Membuat object Film dan menyimpannya ke ArrayList
        daftarFilm.add(
            new Film(id, judul, genre, durasi, sutradara)
        );

        System.out.println("\nData film berhasil ditambahkan");
    }

    // Menampilkan seluruh data film
    static void tampilkanData()
    {
        System.out.println("\n--- Daftar Film ---");

        // Mengecek apakah belum ada data film
        if (daftarFilm.isEmpty())
        {
            System.out.println("\nData film kosong");
            return;
        }

        // Menampilkan setiap object Film
        for (Film film : daftarFilm)
        {
            film.tampilkanData();
            System.out.println();
        }
    }

    // Mengubah data film berdasarkan ID
    static void updateData()
    {
        System.out.println("\n--- Update Data Film ---");

        System.out.print(
            "Masukkan ID Film yang akan diupdate: "
        );
        String id = input.nextLine();

        int index = cariIndex(id);

        // Jika ID tidak ditemukan
        if (index == -1)
        {
            System.out.println(
                "Film dengan ID " + id + " tidak ditemukan"
            );
            return;
        }

        System.out.print("Judul baru: ");
        String judul = input.nextLine();

        System.out.print("Genre baru: ");
        String genre = input.nextLine();

        int durasi = inputDurasi();

        System.out.print("Sutradara baru: ");
        String sutradara = input.nextLine();

        // Memperbarui data object Film
        daftarFilm.get(index).update(
            judul, genre, durasi, sutradara
        );

        System.out.println("\nData film berhasil diupdate");
    }

    // Menghapus data film berdasarkan ID
    static void hapusData()
    {
        System.out.println("\n--- Hapus Data Film ---");

        System.out.print(
            "Masukkan ID Film yang akan dihapus: "
        );
        String id = input.nextLine();

        int index = cariIndex(id);

        // Jika ID tidak ditemukan
        if (index == -1)
        {
            System.out.println(
                "Film dengan ID " + id + " tidak ditemukan"
            );
            return;
        }

        // Menghapus object Film dari ArrayList
        daftarFilm.remove(index);

        System.out.println("\nData film berhasil dihapus");
    }

    // Mencari dan menampilkan film berdasarkan ID
    static void cariData()
    {
        System.out.println("\n--- Cari Data Film ---");

        System.out.print(
            "Masukkan ID Film yang akan dicari: "
        );
        String id = input.nextLine();

        int index = cariIndex(id);

        // Jika film tidak ditemukan
        if (index == -1)
        {
            System.out.println("\nData film tidak ditemukan");
            return;
        }

        System.out.println("\nData film ditemukan");
        daftarFilm.get(index).tampilkanData();
    }

    // Menjalankan program utama
    public static void main(String[] args)
    {
        int pilihan;

        // Menampilkan menu sampai pengguna memilih keluar
        do
        {
            tampilkanMenu();

            // Error handling untuk pilihan menu
            try
            {
                pilihan = input.nextInt();
                input.nextLine();

                if (pilihan < 1 || pilihan > 6)
                {
                    System.out.println(
                        "Pilihan harus antara 1 sampai 6."
                    );
                    continue;
                }
            }
            catch (Exception e)
            {
                System.out.println(
                    "Pilihan harus berupa angka!"
                );
                input.nextLine();
                pilihan = 0;
                continue;
            }

            // Menjalankan fitur sesuai pilihan pengguna
            switch (pilihan)
            {
                case 1:
                    tambahData();
                    break;

                case 2:
                    tampilkanData();
                    break;

                case 3:
                    updateData();
                    break;

                case 4:
                    hapusData();
                    break;

                case 5:
                    cariData();
                    break;

                case 6:
                    System.out.println(
                        "Terima kasih telah menggunakan program ini"
                    );
                    break;
            }

        } while (pilihan != 6);

        // Menutup Scanner setelah program selesai
        input.close();
    }
}