import { ORDER_API_URL } from "./config";
import axios from "axios";

export const orderService = axios.create({
  baseURL: ORDER_API_URL
});
