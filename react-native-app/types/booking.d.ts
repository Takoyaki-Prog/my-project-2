export interface BookingResponse {
  success: boolean;
  message: string;
  data: {
    id: number;
    status?: string;
    imageUrl: any;
    unitName: string;
    blockName: string;
    typeName: string;
    price: number;
    cost: number;
    paymentDeadline: Date;
    marketingPhoto: any;
    marketingName: string;
    marketingEmail: string;
    marketingPhone: string;
  };
}

export interface ListBookingResponse {
  success: boolean;
  message: string;
  data: {
    id: number;
    cost: number;
    paymentDeadline: Date;
    status: "aktif" | "terbayar" | "selesai" | "dibatalkan";
    unitName: string;
    imageUrl: any;
    typeName: string;
    price: number;
    blockName: string;
  }[];
}
