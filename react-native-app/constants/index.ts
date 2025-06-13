import type { Block, Booking, Facility, HouseType, HouseTypeGalery, HouseUnit, Payment, User } from "@/types/index.";

export const USERS: User[] = [
  { id: 1, photoUrl: require("@/assets/images/user.jpg"), name: "Admin", email: "admin@mail.com", role: "admin" },
  { id: 2, photoUrl: require("@/assets/images/user.jpg"), name: "Marketing", email: "marketing@mail.com", role: "marketing" },
  { id: 3, photoUrl: require("@/assets/images/user.jpg"), name: "Customer", email: "customer@mail.com", role: "customer" },
];

export const HOUSE_TYPES: HouseType[] = [
  {
    id: 1,
    imageUrl: require("@/assets/images/tipe-rumah-1.jpg"),
    name: "Tipe 30/60",
    summary: "Lorem ipsum dolor sit amet consectetur adipisicing elit. Nulla, officia! Voluptas consequatur itaque deleniti distinctio, eaque commodi facere impedit officia veritatis laboriosam architecto amet dolore similique! Nemo veritatis earum cumque.",
    price: 100_000_000,
  },
  {
    id: 2,
    imageUrl: require("@/assets/images/tipe-rumah-2.jpg"),
    name: "Tipe 32/60",
    summary: "Lorem ipsum dolor sit amet consectetur adipisicing elit. Nulla, officia! Voluptas consequatur itaque deleniti distinctio, eaque commodi facere impedit officia veritatis laboriosam architecto amet dolore similique! Nemo veritatis earum cumque.",
    price: 120_000_000,
  },
];

export const BLOCKS: Block[] = [
  { id: 1, name: "Blok A" },
  { id: 2, name: "Blok B" },
  { id: 3, name: "Blok C" },
  { id: 4, name: "Blok D" },
  { id: 5, name: "Blok E" },
];

export const HOUSE_UNITS: HouseUnit[] = [
  {
    id: 1,
    imageUrl: require("@/assets/images/unit-rumah.jpg"),
    name: "A1",
    block: BLOCKS[0],
    type: HOUSE_TYPES[0],
    marketing: USERS[1],
  },
  {
    id: 2,
    imageUrl: require("@/assets/images/unit-rumah.jpg"),
    name: "A2",
    block: BLOCKS[0],
    type: HOUSE_TYPES[0],
    marketing: USERS[1],
  },
  {
    id: 3,
    imageUrl: require("@/assets/images/unit-rumah.jpg"),
    name: "A3",
    block: BLOCKS[0],
    type: HOUSE_TYPES[0],
    marketing: USERS[1],
  },
  {
    id: 4,
    imageUrl: require("@/assets/images/unit-rumah.jpg"),
    name: "A4",
    block: BLOCKS[0],
    type: HOUSE_TYPES[0],
    marketing: USERS[1],
  },
  {
    id: 5,
    imageUrl: require("@/assets/images/unit-rumah.jpg"),
    name: "B1",
    block: BLOCKS[1],
    type: HOUSE_TYPES[1],
    marketing: USERS[1],
  },
  {
    id: 6,
    imageUrl: require("@/assets/images/unit-rumah.jpg"),
    name: "B2",
    block: BLOCKS[1],
    type: HOUSE_TYPES[1],
    marketing: USERS[1],
  },
  {
    id: 7,
    imageUrl: require("@/assets/images/unit-rumah.jpg"),
    name: "B3",
    block: BLOCKS[1],
    type: HOUSE_TYPES[1],
    marketing: USERS[1],
  },
  {
    id: 8,
    imageUrl: require("@/assets/images/unit-rumah.jpg"),
    name: "B4",
    block: BLOCKS[1],
    type: HOUSE_TYPES[1],
    marketing: USERS[1],
  },
];

export const FACILITIES: Facility[] = [
  { id: 1, imageUrl: require("@/assets/images/fasilitas.jpg"), name: "Fasilitas 1", description: "Lorem ipsum dolor sit amet consectetur adipisicing elit. Sit, dolorem." },
  { id: 2, imageUrl: require("@/assets/images/fasilitas.jpg"), name: "Fasilitas 2", description: "Lorem ipsum dolor sit amet consectetur adipisicing elit. Sit, dolorem." },
  { id: 3, imageUrl: require("@/assets/images/fasilitas.jpg"), name: "Fasilitas 3", description: "Lorem ipsum dolor sit amet consectetur adipisicing elit. Sit, dolorem." },
  { id: 4, imageUrl: require("@/assets/images/fasilitas.jpg"), name: "Fasilitas 4", description: "Lorem ipsum dolor sit amet consectetur adipisicing elit. Sit, dolorem." },
  { id: 5, imageUrl: require("@/assets/images/fasilitas.jpg"), name: "Fasilitas 5", description: "Lorem ipsum dolor sit amet consectetur adipisicing elit. Sit, dolorem." },
  { id: 6, imageUrl: require("@/assets/images/fasilitas.jpg"), name: "Fasilitas 6", description: "Lorem ipsum dolor sit amet consectetur adipisicing elit. Sit, dolorem." },
];

export const HOUSE_TYPE_GALLERIES: HouseTypeGalery[] = [
  { id: 1, imageUrl: require("@/assets/images/galeri-1.jpg"), name: "Tampak depan", description: "Lorem ipsum dolor sit amet consectetur adipisicing elit. Non, sit." },
  { id: 2, imageUrl: require("@/assets/images/galeri-2.jpg"), name: "Tampak samping kiri", description: "Lorem ipsum dolor sit amet consectetur adipisicing elit. Non, sit." },
  { id: 3, imageUrl: require("@/assets/images/galeri-1.jpg"), name: "Tampak samping kanan", description: "Lorem ipsum dolor sit amet consectetur adipisicing elit. Non, sit." },
  { id: 4, imageUrl: require("@/assets/images/galeri-2.jpg"), name: "Tampak belakang", description: "Lorem ipsum dolor sit amet consectetur adipisicing elit. Non, sit." },
  { id: 5, imageUrl: require("@/assets/images/galeri-1.jpg"), name: "Tampak atas", description: "Lorem ipsum dolor sit amet consectetur adipisicing elit. Non, sit." },
  { id: 6, imageUrl: require("@/assets/images/galeri-2.jpg"), name: "Tampak dalam", description: "Lorem ipsum dolor sit amet consectetur adipisicing elit. Non, sit." },
];

export const HOUSE_UNIT_GALLERIES: HouseTypeGalery[] = [
  { id: 1, imageUrl: require("@/assets/images/galeri-1.jpg"), name: "Tampak depan", description: "Lorem ipsum dolor sit amet consectetur adipisicing elit. Non, sit." },
  { id: 2, imageUrl: require("@/assets/images/galeri-2.jpg"), name: "Tampak samping kiri", description: "Lorem ipsum dolor sit amet consectetur adipisicing elit. Non, sit." },
  { id: 3, imageUrl: require("@/assets/images/galeri-1.jpg"), name: "Tampak samping kanan", description: "Lorem ipsum dolor sit amet consectetur adipisicing elit. Non, sit." },
  { id: 4, imageUrl: require("@/assets/images/galeri-2.jpg"), name: "Tampak belakang", description: "Lorem ipsum dolor sit amet consectetur adipisicing elit. Non, sit." },
  { id: 5, imageUrl: require("@/assets/images/galeri-1.jpg"), name: "Tampak atas", description: "Lorem ipsum dolor sit amet consectetur adipisicing elit. Non, sit." },
  { id: 6, imageUrl: require("@/assets/images/galeri-2.jpg"), name: "Tampak dalam", description: "Lorem ipsum dolor sit amet consectetur adipisicing elit. Non, sit." },
];

export const BOOKINGS: Booking[] = [
  { id: 1, cost: 500_000, paymentDeadline: new Date(), status: "aktif", unit: HOUSE_UNITS[0] },
  { id: 2, cost: 500_000, paymentDeadline: new Date(), status: "dibayar", unit: HOUSE_UNITS[1] },
  { id: 3, cost: 500_000, paymentDeadline: new Date(), status: "selesai", unit: HOUSE_UNITS[2] },
  { id: 4, cost: 500_000, paymentDeadline: new Date(), status: "dibatalkan", unit: HOUSE_UNITS[3] },
];

export const SETTINGS = [
  { icon: "book-online", name: "Daftar Booking", href: "/bookings" },
  { icon: "notifications", name: "Notifikasi", href: "#" },
];

export const PAYMENTS: Payment[] = [
  { id: 1, amount: 500_000, status: "tertunda", booking: BOOKINGS[1] },
  { id: 2, amount: 500_000, status: "berhasil", booking: BOOKINGS[1] },
  { id: 3, amount: 500_000, status: "gagal", booking: BOOKINGS[1] },
];
