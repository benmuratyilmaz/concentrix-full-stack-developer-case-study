import "./Modal.css";
import type { User } from "../../Models";

type Props = {
  open: boolean;
  onClose: () => void;
  detail: User | null;
};

export default function Modal({ open, onClose, detail }: Props) {
  if (!open) return null;

  if (!detail) return "Load Error";

  return (
    <div className="modal-overlay" role="dialog" aria-modal="true">
      <div className="modal">
        <div className="header">
          <h3>Detail</h3>
          <button type="button" onClick={onClose} aria-label="Close">
            Close
          </button>
        </div>
        <div className="body">
          <ul>
            <li>Username:</li>
            <li> {detail.username} </li>
            <li>Name:</li>
            <li> {detail.name} </li>
            <li>Phone:</li>
            <li> {detail.phone} </li>
            <li>Company:</li>
            <li> {detail.company.name} </li>
            <li>Email:</li>
            <li> {detail.email} </li>
            <li>Address:</li>
            <li>
              {detail.address.street +
                " " +
                detail.address.suite +
                " " +
                detail.address.city +
                " " +
                detail.address.zipcode}
            </li>
            <li>Website:</li>
            <li>{detail.website}</li>
          </ul>
        </div>
      </div>
    </div>
  );
}
