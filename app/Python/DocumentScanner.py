import pyscanner
import hashlib

def generate_hash_name(file_path)
    # generate a hash name based on file path.
    file_hash = hashlib.sha256(file_path.encode()).hexdigest()
    return f"output_document_{file_hash}.jpeg";

def scan_document(outputPath):
    scanner = pyscanner.Scanner()
    scanner.init()

    try:
        # Perform scan
        scanner.acquire_to_file(output_path, format="JPEG",resolution=300)
    finally:
        scanner.close()

if __name__ == '__main__':
    scan_and_save_document()
