import { StrictMode } from "react";
import { createRoot } from "react-dom/client";
import "./index.css";
import {
  createBrowserRouter,
  createRoutesFromElements,
  Route,
  RouterProvider,
} from "react-router-dom";
import Registration from "./pages/Registration.jsx";
import Layouts from "./Layouts.jsx";

const router = createBrowserRouter(
  createRoutesFromElements(
    <Route path="" element={<Layouts/>} >
      <Route path="/" element={<Registration />} />

    </Route>
  )
);

createRoot(document.getElementById("root")).render(
  <StrictMode>
    {/* <App /> */}
    <RouterProvider router={router} />
  </StrictMode>
);
